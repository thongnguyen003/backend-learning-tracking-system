<?php
namespace App\Repositories;

use App\Models\JournalGoal;

interface JournalGoalRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function delete($id);
}