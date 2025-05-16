<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository {
    protected Model $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function all(): Collection {
        return $this->model->all();
    }

    public function find(int $id): ?Model {
        return $this->model->find($id);
    }

    public function create(array $data): Model {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?Model {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete(int $id): bool {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
