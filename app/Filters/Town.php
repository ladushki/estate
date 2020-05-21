<?php

namespace App\Filters;

use App\Interfaces\Filter;
use Illuminate\Database\Eloquent\Builder;

class Town implements Filter
{

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('town', 'like', '%'.$value.'%');
    }
}
