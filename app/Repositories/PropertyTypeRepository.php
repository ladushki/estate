<?php declare(strict_types = 1);

namespace App\Repositories;

use App\PropertyType;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;

/**
 * Class PropertyTypeRepository
 *
 * @package App\Repositories
 */
class PropertyTypeRepository implements PropertyTypeRepositoryInterface
{

    /**
     * @var \App\PropertyType
     */
    private PropertyType $model;

    /**
     * PropertyTypeRepository constructor.
     *
     * @param \App\PropertyType $model
     */
    public function __construct(PropertyType $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getList(): \Illuminate\Support\Collection
    {
        return $this->model->all()->pluck('title', 'id');
    }

    /**
     * @param array $item
     * @return bool
     */
    public function save(array $item): bool
    {
        if (! $this->model->validate($item)){
          return false;
        }

        $this->model->updateOrCreate(['id' => $item['id']],
            [
                'title' => $item['title'],
                'description' => $item['description'],
            ]
        );
        return true;
    }

    /**
     * @return \App\PropertyType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
      return $this->model->all();
    }

}
