<?php
namespace App\Repositories;

use App\Models\JournalGoal;

class JournalGoalRepository implements JournalGoalRepositoryInterface
{
    public function all()
    {
        return JournalGoal::all();
    }

    public function find($id)
    {
        return JournalGoal::find($id);
    }

    public function create(array $data)
    {
        return JournalGoal::create($data);
    }

    public function delete($id)
    {
        return JournalGoal::destroy($id);
    }
}