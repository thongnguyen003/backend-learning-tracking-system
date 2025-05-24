<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AdminRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AdminService extends BaseService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        parent::__construct($adminRepository);
        $this->adminRepository = $adminRepository;
    }

    public function getAll($search = ''): Collection
    {
        return $this->adminRepository->search($search);
    }

    public function create(array $data): Model
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->adminRepository->create($data);
    }

    public function createMultiple(array $users): array
    {
        $createdUsers = [];
        foreach ($users as $userData) {
            if (!isset($userData['role']) || $userData['role'] !== 'admin') {
                continue;
            }
            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }
            $createdUsers[] = $this->adminRepository->create($userData);
        }
        return $createdUsers;
    }

    public function getById($id): ?Model
    {
        return $this->adminRepository->findById($id);
    }

    public function update($id, array $data): ?Model
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->adminRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->adminRepository->delete($id);
    }
}