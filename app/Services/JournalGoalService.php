<?php
namespace App\Services;

use App\Repositories\JournalGoalRepositoryInterface;

class JournalGoalService
{
    protected $repository;

    public function __construct(JournalGoalRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllGoals()
    {
        return $this->repository->all();
    }

    public function getGoalById($id)
    {
        return $this->repository->find($id);
    }

    public function createGoal(array $data)
    {
        return $this->repository->create($data);
    }

    public function deleteGoal($id)
    {
        return $this->repository->delete($id);
    }
    public function updateGoal($id, array $data)
    {
        return $this->repository->update($id, $data);
    }
}