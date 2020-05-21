<?php declare(strict_types = 1);

namespace App\Repositories;

use App\Property;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PropertyRepositoryInterface;

class PropertyRepository implements PropertyRepositoryInterface
{

    /**
     * @var \App\Property
     */
    private Property $model;

    public function __construct(Property $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        if (! $this->model->validate($data)) {
            return false;
        }

        $existing = $this->model->withTrashed()->where('uuid', '=', $data['uuid'])->first();

        if (! $existing) {
            return $this->model->insert($data);
        }

        if ($existing->needsUpdate($data)) {
            return (boolean) $existing->update($data)->restore();
        }

        return false;
    }

    /**
     * @return \App\Property[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function paginated(string $type = 'sale')
    {
        return $this->model->ofType($type)->paginate();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $type
     * @return mixed
     */
    public function search(Request $request, $type = 'sale')
    {
        return Property::apply($request)->ofType($type)->paginate();
    }

    /**
     * @return \App\Property
     */
    public function getModel(): Property
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return $this
     */
    public function setModel($model): PropertyRepository
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);

        return $record->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }
}
