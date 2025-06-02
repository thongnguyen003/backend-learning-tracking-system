<?php
namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseService {
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }

    public function getAll(): Collection {
        return $this->repository->all();
    }

    public function getById(int $id) {
        return $this->repository->find($id);
    }

    public function create(array $data) {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data) {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id) {
        return $this->repository->delete($id);
    }
}
