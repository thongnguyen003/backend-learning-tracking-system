<?php
namespace App\Services;
use App\Repositories\MessageRepository;
class MessageService extends Service {
    public function __construct(MessageRepository $repo){
        $this->repository = $repo;
    }
    public function getMessageDetailByJournalGoalId($id){
        return $this->repository->getMessageDetailByJournalGoalId($id);
    }

    public function getMessageDetailByCourseGoalId($id){
        return $this->repository->getMessageDetailByCourseGoalId($id);
    }
}