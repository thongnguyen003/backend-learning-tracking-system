<?php

namespace App\Services;

use App\Models\Classes;
use App\Repositories\ClassRepository;

class ClassService
{
    protected $classRepository;

    public function __construct(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    
    public function getAllClasses()
    {
        return $this->classRepository->getAll();
    }

    public function createClass(array $data)
    {
        return $this->classRepository->create($data);
    }

    public function getClassDetailsByTeacherId($teacherId)
    {
        return $this->classRepository->getByTeacherId($teacherId);
    }

    public function getClassById($id)
    {
        return $this->classRepository->findById($id);
    }
}