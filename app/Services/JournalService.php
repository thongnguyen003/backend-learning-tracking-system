<?php
namespace App\Services;
use App\Repositories\JournalRepository;
class JournalService extends Service {
    public function __construct(JournalRepository $repo){
        $this->repository = $repo;
    }
    public function getJournalsDetailsByCourseStudentId(int $id){
        return $this->repository->getJournalsDetailByCourseStudentId($id);
    }
}