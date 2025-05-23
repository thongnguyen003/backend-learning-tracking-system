<?php

namespace App\Services\Admin;

use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

class AdminTeacherService
{
    protected $model;

    public function __construct(Teacher $model)
    {
        $this->model = $model;
    }

    public function createMultiple(array $users)
    {
        $created = [];
        foreach ($users as $user) {
            Log::info('Creating teacher:', $user);
            $createdUser = $this->model->create([
                'teacher_name' => $user['teacher_name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'day_of_birth' => $user['day_of_birth'] ?? null,
                'hometown' => $user['hometown'] ?? null,
                'phone_number' => $user['phone_number'] ?? null,
            ]);
            Log::info('Created teacher:', $createdUser->toArray());
            $created[] = $createdUser;
        }
        return $created;
    }

    public function getAll($search = '')
    {
        return $this->model
            ->where('teacher_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $user = $this->model->find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        if ($user) {
            $user->delete();
        }
    }
}