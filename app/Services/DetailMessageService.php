<?php
namespace App\Services;
use App\Repositories\DetailMessageRepository;
class DetailMessageService extends Service {
    public function __construct(DetailMessageRepository $repo){
        $this->repository = $repo;
    }
    public function getCoursesDetailsByStudentId(int $studentId){
        return $this->repository->getCoursesDetailsByStudentId($studentId);
    }
}