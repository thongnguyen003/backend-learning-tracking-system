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
    public function store($message_id,$student_id,$teacher_id,$content){
        $this->repository->addDetailMessage($message_id,$student_id,$teacher_id,$content);
    }
}