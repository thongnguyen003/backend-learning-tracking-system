<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminTeacherRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AdminTeacherService extends BaseService
{
    protected $teacherRepository;

    public function __construct(AdminTeacherRepository $teacherRepository)
    {
        parent::__construct($teacherRepository);
        $this->teacherRepository = $teacherRepository;
    }

    public function getAll($search = ''): Collection
    {
        return $this->teacherRepository->search($search);
    }

    public function create(array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->teacherRepository->create($data);
    }

    public function createMultiple(array $users): array
    {
        $createdUsers = [];
        foreach ($users as $userData) {
            if (!isset($userData['role']) || $userData['role'] !== 'teacher') {
                continue;
            }
            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }
            $createdUsers[] = $this->teacherRepository->create($userData);
        }
        return $createdUsers;
    }

    public function getById($id): ?Model
    {
        return $this->teacherRepository->findById($id);
    }

    public function update($id, array $data): ?Model
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->teacherRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->teacherRepository->delete($id);
    }
}