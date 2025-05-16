<?php

namespace App\Repositories;
use App\Models\JournalSelf;
class JournalSelfRepository
{
    protected $model;
    public function __construct(JournalSelf $journalSelf)
    {
        $this->model = $journalSelf;
    }

    public function getAll()
    {
        return $this->model->all();
    }
    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $journalSelf = $this->findById($id);
        if ($journalSelf) {
            $journalSelf->update($data);
            return $journalSelf;
        }
        return null;
    }

    public function delete($id)
    {
        $journalSelf = $this->findById($id);
        if ($journalSelf) {
            return $journalSelf->delete();
        }
        return false;
    }
}
