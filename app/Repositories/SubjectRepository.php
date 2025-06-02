<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository
{
    public function all()
    {
        return Subject::all();
    }

    public function find($id)
    {
        return Subject::find($id);
    }

    public function create(array $data)
    {
        return Subject::create($data);
    }

    public function update($id, array $data)
    {
        $subject = $this->find($id);
        if ($subject) {
            $subject->update($data);
            return $subject;
        }
        return null;
    }

    public function delete($id)
    {
        $subject = $this->find($id);
        if ($subject) {
            $subject->delete();
            return true;
        }
        return false;
    }
}