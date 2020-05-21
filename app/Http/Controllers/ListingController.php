<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingController extends BaseController
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
     * @param \Illuminate\Http\Request $request Request.
     * @param                          $type    Type.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $type)
    {
        $type = ! in_array($type, ['rent', 'sale']) ? 'sale' : $type;

        try {
            $properties = $this->repo->search($request, $type);
            $links = $properties->links();
            $input = $request->all();
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }

        return view('listing', compact('properties', 'links', 'type', 'input'));
    }

    /**
     * @param string                      $id      Id.
     * @param \App\Http\Requests\Property $request Request.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $id, \App\Http\Requests\Property $request)
    {
        try {
            $item = $this->repo->show($id);
            $form = $request->form(route('admin.update', [$id]))->model($item);
            $form->property_type_id->options($this->typeRepo->getList());
            $range = range(1, 10);
            $options = array_combine($range, $range);
            $form->num_bedrooms->options($options);
            $form->num_bathrooms->options($options);
            $form->type->options(['sale' => 'sale', 'rent' => 'rent']);
            $form->id->value($id);
            $form->uuid->value($id);
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }

        return view('admin.edit', compact('form', 'item'));
    }

    /**
     * @param \App\Http\Requests\Property $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(\App\Http\Requests\Property $request)
    {
        try {
            $data = $request->validated();
            $id = (string) $request->get('uuid');

            $upload = $this->upload($request);

            if (! empty($upload)) {
                [$data['image_full'], $data['image_thumbnail']] = $upload;
            }

            if (! empty($id)) {
                $data['is_locked'] = 1;
                $this->repo->update($data, $id);
            }
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }

        return redirect(route('admin.show', [$id]))->with('success', 'Success!');
    }

    /**
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id)
    {
        try {
            $item = $this->repo->show($id);
        } catch (\Throwable $exception) {
            abort(500, $exception->getMessage());
        }

        return view('admin.show')->with('item', $item);
    }

    /**
     * @param \App\Http\Requests\Property $request
     * @return array
     */
    public function upload(\App\Http\Requests\Property $request): array
    {
        if (! $request->has('image_full')) {
            return [];
        }
        $file = $request->file('image_full');

        return $this->uploadHandler->upload($file);
    }

}
