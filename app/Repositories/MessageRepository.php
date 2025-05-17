<?php
namespace App\Repositories;
use App\Models\Message;
class MessageRepository  extends Repository
{
    public function __construct(Message $model){
        $this->model = $model;
    }
    public function getMessageDetailByJournalGoalId($id){
        $result = Message::where('journal_goal_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        return response()->json($result);
    }

    public function getMessageDetailByCourseGoalId($id){
        $result = Message::where('course_goal_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);

        }])
        ->with("course_goal.course_student.student.class.class_teachers.teacher")
        ->get();
        return response()->json($result);
    }
}