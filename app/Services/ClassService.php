<?php
namespace App\Services;
use App\Repositories\ClassRepository;
class ClassService extends Service {
    public function __construct(ClassRepository $repo){
        $this->repository = $repo;
    }
    public function getClassDetailsByTeacherId(int $teacherId){
        return $this->repository->getClassDetailsByTeacherId($teacherId);
    }
}