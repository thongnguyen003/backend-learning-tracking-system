<?php

namespace App\Repositories;

use App\Models\JournalTime;

class JournalTimeRepository extends BaseRepository
{
    public function __construct(JournalTime $model){
        parent::__construct($model);
    }
    public function getAll()
    {
        return JournalTime::all();
    }

    public function find(int $id){
        return parent::find($id);
    }

    public function create(array $data)
    {
        return JournalTime::create($data);
    }

    public function update(int $id,array $data){
        return parent::update( $id, $data);
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