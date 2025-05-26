<?php
namespace App\Services;
use App\Repositories\DetailMessageRepository;
use App\Repositories\MessageUserRepository;
use App\Repositories\MessageRepository;
use App\Models\DetailMessage;
use App\Models\MessageUser;
class MessageService extends BaseService {
    public function __construct(MessageRepository $repo){
        parent::__construct($repo);
    }
    public function getMessageDetailByJournalGoalId($id){
        return $this->repository->getMessageDetailByJournalGoalId($id);
    }

    public function getMessageDetailByCourseGoalId($id){
        return $this->repository->getMessageDetailByCourseGoalId($id);
    }
    public function getMessageDetailByJournalClassId($id){
        return $this->repository->getMessageDetailByJournalClassId($id);
    }
    public function getMessageDetailByJournalSelfId($id){
        return $this->repository->getMessageDetailByJournalSelfId($id);
    }
    public function store($course_goal_id,$journal_goal_id,$journal_class_id,$journal_self_id,$student_id,$teacher_id,$content,$view_teacher_id){
        $detailMessage = new DetailMessageRepository(new DetailMessage);
        $messageUser = new MessageUserRepository(new MessageUser);
        $message = $this->repository->addMessage($course_goal_id, $journal_goal_id,$journal_class_id,$journal_self_id);
        if($message){
            $message_id = $message->id;
            $messageUser->addMessageUser($message_id,$view_teacher_id);
            $detail = $detailMessage->addDetailMessage($message_id,$student_id,$teacher_id,$content);
        }

    }
    public function delete(int $id):bool{
        parent::delete($id);
    }
}