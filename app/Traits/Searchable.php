<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{

    /**
     * @param \Illuminate\Http\Request $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function apply(Request $filters): Builder
    {
        return static::applyDecoratorsFromRequest($filters, (static::getModel())->query());
    }

    /**
     * @param \Illuminate\Http\Request              $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private static function applyDecoratorsFromRequest(Request $request, Builder $query): Builder
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    /**
     * @param $name
     * @return string
     * @throws \ReflectionException
     */
    private static function createFilterDecorator($name): string
    {
        $class = new \ReflectionClass(__CLASS__);

        return $class->getNamespaceName() . '\\Filters\\' . Str::studly($name);
    }

    /**
     * @param string $decorator
     * @return bool
     */
    private static function isValidDecorator(string $decorator): bool
    {
        return class_exists($decorator);
    }

}
