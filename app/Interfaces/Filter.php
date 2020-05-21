<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param string|array|integer|float $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value);
}
