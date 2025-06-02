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
    

    public function getAll()
    {
        return $this->model->select('id', 'name')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getByTeacherId($teacherId)
    {
        return $this->model->where('teacher_id', $teacherId)->select('id', 'name')->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
    public function findStudents ($class_id){
        $result = $this->model::where('id',$class_id)
        ->with(['students'])
        ->get();
        if($result && count($result)>0){
            return $result[0]->students;
        }
        return false;
    }
}