<?php

namespace App\Services;

use App\Repositories\JournalTimeRepository;

class JournalTimeService
{
    protected $repository;

    public function __construct(JournalTimeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllJournalTimes()
    {
        return $this->repository->getAll();
    }

    public function getJournalTimeById($id)
    {
        return $this->repository->getById($id);
    }

    public function createJournalTime(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateJournalTime($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteJournalTime($id)
    {
        return $this->repository->delete($id);
    }

    public function getJournalTimesByCourseId($courseId)
    {
        return $this->repository->getByCourseId($courseId);
    }
}