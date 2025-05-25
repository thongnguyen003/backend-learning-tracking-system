<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AdminRepository extends BaseRepository
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function search($search = ''): Collection
    {
        return $this->model
            ->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();
    }

    public function findById($id)
    {
        return $this->find($id);
    }
}