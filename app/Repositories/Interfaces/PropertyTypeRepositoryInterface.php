<?php

namespace App\Repositories\Interfaces;


interface PropertyTypeRepositoryInterface
{
    public function all();

    public function save(array $data);

}
