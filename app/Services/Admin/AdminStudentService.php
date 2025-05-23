<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminStudentRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AdminStudentService extends BaseService
{
    protected $studentRepository;

    public function __construct(AdminStudentRepository $studentRepository)
    {
        parent::__construct($studentRepository);
        $this->studentRepository = $studentRepository;
    }

    public function getAll($search = ''): Collection
    {
        return $this->studentRepository->search($search);
    }

    public function create(array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->studentRepository->create($data);
    }

    public function createMultiple(array $users): array
    {
        $createdUsers = [];
        foreach ($users as $user) {
            $createdUsers[] = $this->repository->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'],
                'class_id' => $user['class_id'], // Thêm class_id
            ]);
        }
        return $createdUsers;
    }

    public function getById($id): ?Model
    {
        return $this->studentRepository->findById($id);
    }

    public function update($id, array $data): ?Model
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->studentRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->studentRepository->delete($id);
    }
}