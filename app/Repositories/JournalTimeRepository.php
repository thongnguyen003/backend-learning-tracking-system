<?php

namespace App\Repositories;

use App\Models\JournalTime;

class JournalTimeRepository
{
    public function getAll()
    {
        return JournalTime::all();
    }

    public function getById($id)
    {
        return JournalTime::find($id);
    }

    public function create(array $data)
    {
        return JournalTime::create($data);
    }

    public function update($id, array $data)
    {
        $journalTime = $this->getById($id);
        if ($journalTime) {
            $journalTime->update($data);
            return $journalTime;
        }
        return null;
    }

    public function delete($id)
    {
        return JournalTime::destroy($id);
    }

    public function getByCourseId($courseId)
    {
        return JournalTime::where('course_id', $courseId)->get();
    }
}