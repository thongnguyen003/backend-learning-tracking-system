<?php
namespace App\Repositories;
use App\Models\DetailMessage;
class DetailMessageRepository  extends Repository
{ 
    public function __construct(DetailMessage $model){
        $this->model = $model;
    }
    public function addDetailMessage($message_id, $student_id,$teacher_id,$content){
        $detail = new DetailMessage;
        $detail->message_id = $message_id;
        $detail->student_id = $student_id ?? null;
        $detail->teacher_id = $teacher_id ?? null;
        $detail->content = $content;
        $detail->time = now();
        $detail->save();
    }
}