<?php declare(strict_types = 1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface Searchable
{

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getModel(): Model;
}
