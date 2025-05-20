<?php
namespace App\Repositories;
use App\Models\DetailMessage;
class DetailMessageRepository  extends BaseRepository
{ 
    public function __construct(DetailMessage $model){
        parent::__construct($model);
    }
    public function addDetailMessage($message_id, $student_id,$teacher_id,$content){
        $detail = new $this->model;
        $detail->message_id = $message_id;
        $detail->student_id = $student_id ?? null;
        $detail->teacher_id = $teacher_id ?? null;
        $detail->content = $content;
        $detail->time = now();
        $detail->save();
    }
    public function delete(int $id){
        parent::delete($id);
    }
    public function updateMessage(array $array, int $id){
        $message = $this->model->find($id);
        if(!$message || count($array) < 1){
            throw new \Exception("invalid");
        }
        foreach($array as $index => $value){
            $message->$index = $value;
        }
        $message->save();
    }
}