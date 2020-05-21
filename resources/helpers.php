<?php

use Illuminate\Support\Str;

function str_contains($str, $search) {
    return Str::contains($str, $search);
}
if (!function_exists('dd_query')) {
    $_global_query_count = 0;
    /**
     * Dump the next database query.
     * Quick fix for not rendering dd_query() in browser's network tab.
     *
     * @return void
     */
    function dd_query(int $count = 1): void
    {
        DB::listen(static function ($query) use ($count): void {
            global $_global_query_count;

            while (strpos($query->sql, '?')) {
                $query->sql = preg_replace('/\?/', '"' . array_shift($query->bindings) . '"', $query->sql, 1);
            }

            if (++$_global_query_count === $count) {
                dd($query->sql);
            } else {
                dp($query->sql);
            }
        });
    }
}

if (! function_exists('dp')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dp(...$args): void
    {
        foreach ($args as $x) {
            dump($x);
        }
    }
}

if (! function_exists('dd_if')) {
    /**
     * @param  mixed           $value
     * @param  Closure|boolean $condition
     * @return void
     */
    function dd_if($value, $condition): void
    {
        if ($condition instanceof \Closure) {
            $condition = $condition($value);
        }

        if (!$condition) {
            return;
        }

        dd($value);
    }
}
/**
 * @SuppressWarnings(PHPMD)
 *
 */
if (! function_exists('dump_until')) {
    /**
     * @param  mixed           $value
     * @param  Closure|boolean $condition
     * @return void
     */
    function dump_until($value, $condition): void
    {
        dump($value);

        if ($condition instanceof \Closure) {
            $condition = $condition($value);
        }

        if ($condition) {
            die;
        }
    }
}
