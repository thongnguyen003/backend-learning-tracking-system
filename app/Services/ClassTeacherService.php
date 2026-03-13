<?php

namespace App\Services;

use App\Repositories\ClassTeacherRepository;

class ClassTeacherService
{
    protected $repository;

    public function __construct(ClassTeacherRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
    public function getTeachersByClassId($classId)
    {
        return $this->repository->findTeachersByClassId($classId);
    }
    public function getByClassAndTeacher($classId, $teacherId)
    {
        return $this->repository->getByClassAndTeacher($classId, $teacherId);
    }
    public function getClassesByTeacherId($teacherId)
    {
        return $this->repository->findClassesByTeacherId($teacherId);
    }
}