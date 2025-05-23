<?php

namespace App\Repositories\Admin;

use App\Models\Teacher;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AdminTeacherRepository extends BaseRepository
{
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    public function search($search = ''): Collection
    {
        return $this->model
            ->where('teacher_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();
    }

    public function findById($id)
    {
        return $this->find($id); // Use parent method
    }
}