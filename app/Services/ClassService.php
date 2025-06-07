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
        return $this->classRepository->getAllClasses();
    }

    public function createClass(array $data)
    {
        return $this->classRepository->create($data);
    }
       public function getClassDetailsByTeacherId(int $teacherId){
        return $this->classRepository->getClassDetailsByTeacherId($teacherId);
    }
    public function getClassById(int $id)
    {
        return $this->classRepository->getClassById($id);
    }
}