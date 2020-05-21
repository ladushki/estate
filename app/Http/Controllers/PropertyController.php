<?php

namespace App\Http\Controllers;

use App\Forms\PropertyForm;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Repositories\PropertyRepository;
use App\Http\Requests\PropertyFormRequest;
use App\Repositories\PropertyTypeRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class PropertyController
 *
 * @package App\Http\Controllers
 */
class PropertyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Repositories\PropertyRepository
     */
    private PropertyRepository $repo;

    /**
     * @var \App\Repositories\PropertyTypeRepository
     */
    private PropertyTypeRepository $typeRepo;

    /**
     * @var \App\Handlers\ImageUploadHandler
     */
    private ImageUploadHandler $uploadHandler;

    public function __construct(
        PropertyRepository $repo,
        PropertyTypeRepository $typeRepo,
        ImageUploadHandler $uploadHandler
    ) {
        $this->repo = $repo;
        $this->typeRepo = $typeRepo;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * @param string $id Id.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $id)
    {
        $item = $this->repo->show($id);
        $data = $item->toArray();
        $data['stype'] = $data['type'];
        unset($data['type']);

        $form = app(PropertyForm::class)
            ->setEndpoint('/admin/process/' . $id)
            ->load($data);

        return view('vue.form', compact('form', 'id'));
    }

    /**
     * @param string              $id      Id.
     * @param PropertyFormRequest $request Request.
     * @return mixed
     */
    public function process(string $id, PropertyFormRequest $request)
    {
        $form = app(config('laraform.path') . '\\' . decrypt($request->key));

        $data = $request->validated()['data'];

        if (! empty($id)) {
            $data['is_locked'] = 1;
            $this->repo->update($data, $id);
        }

        if ($result = $form->fire('after')) {
            return $result;
        }
    }

    /**
     * @param Request $request Request.
     * @return array
     */
    public function upload(Request $request)
    {
        $file = $request->file;

        [$full, $thumbnail] = $this->uploadHandler->upload($file);

        if ($request->has('id')) {
            $item = $this->repo->show($request->get('id'));
            $item->image_full = $full;
            $item->image_thumbnail = $thumbnail;
            $item->save();
        }

        return response()->json(['success' => 'You have successfully upload file.', 'payload' => [$full, $thumbnail]]);
    }

}
