<?php

namespace App\Repositories\Admin;

use App\Models\Student;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AdminStudentRepository extends BaseRepository
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    public function search($search = ''): Collection
    {
        return $this->model
            ->where('student_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();
    }

    public function findById($id)
    {
        return $this->find($id); // Use parent method
    }
}