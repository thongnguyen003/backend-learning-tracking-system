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

public function update($id, array $data)
{
    $goal = JournalGoal::find($id);
    if ($goal) {
        $goal->fill($data); // Fill model with data
        $goal->save(); // Save the updated model
        return $goal;
    }
    return null;
}
}