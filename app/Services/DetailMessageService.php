<?php
namespace App\Services;
use App\Repositories\DetailMessageRepository;
class DetailMessageService extends BaseService {
    public function __construct(DetailMessageRepository $repo){
        parent::__construct($repo);
    }
    public function getCoursesDetailsByStudentId(int $studentId){
        return $this->repository->getCoursesDetailsByStudentId($studentId);
    }
    public function store($message_id,$student_id,$teacher_id,$content){
        $this->repository->addDetailMessage($message_id,$student_id,$teacher_id,$content);
    }
    public function delete(int $id){
        parent::delete($id);
    }
    public function updateMessage($data, $id){
        if($data){
            $this->repository->updateMessage($data,$id);
        }
    }
}