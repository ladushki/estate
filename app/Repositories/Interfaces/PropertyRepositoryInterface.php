<?php

namespace App\Repositories\Interfaces;


interface PropertyRepositoryInterface
{
    public function all();

    public function save(array $data);

    public function create(array $data);

}
