<?php
namespace App\Repositories;
use App\Models\MessageUser;
class MessageUserRepository  extends Repository
{ 
    public function __construct(MessageUser $model){
        $this->model = $model;
    }
    public function addMessageUser($message_id,$teacher_id){
        $detail = new $this->model;
        $detail->message_id = $message_id;
        $detail->teacher_id = $teacher_id ;
        $detail->save();
    }
}