<?php

namespace App\Repositories;

use App\Models\Classes;

class ClassRepository
{
    protected $model;

    public function __construct(Classes $model)
    {
        $this->model = $model;
    }
    public function getAllClasses()
    {
        return Classes::all(); 
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
