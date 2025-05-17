<?php
namespace App\Repositories;
use App\Models\Message;
class MessageRepository  extends Repository
{
    public function __construct(Message $model){
        $this->model = $model;
    }
    public function getMessageDetailByJournalGoalId($id){
        $data = Message::where('journal_goal_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher = Message::where('journal_goal_id', $id)
        ->with("journal_goal.journal.course_student.student.class.class_teachers.teacher")
        ->first();
        if ($teacher && $teacher->journal_goal) {
            $teacherData = $teacher->journal_goal->journal
                ->course_student->student->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data];
        
        return response()->json($result);
    }
    public function getMessageDetailByJournalClassId($id){
        $data = Message::where('journal_class_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher = Message::where('journal_class_id', $id)
        ->with("journal_goal.journal.course_student.student.class.class_teachers.teacher")
        ->first();
        if ($teacher && $teacher->journal_goal) {
            $teacherData = $teacher->journal_goal->journal
                ->course_student->student->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data];
        
        return response()->json($result);
    }
    public function getMessageDetailByJournalSelfId($id){
        $data = Message::where('journal_self_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher = Message::where('journal_self_id', $id)
        ->with("journal_goal.journal.course_student.student.class.class_teachers.teacher")
        ->first();
        if ($teacher && $teacher->journal_goal) {
            $teacherData = $teacher->journal_goal->journal
                ->course_student->student->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data];
        
        return response()->json($result);
    }
    public function addMessage($course_goal_id, $journal_goal_id,$journal_class_id,$journal_self_id){
        $message = new Message;
        $message->course_goal_id = $course_goal_id;
        $message->journal_goal_id = $journal_goal_id ?? null;
        $message->journal_class_id = $journal_class_id ?? null;
        $message->journal_self_id = $journal_self_id;
        $message->save();
        return $message;
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