<?php
namespace App\Repositories;
use App\Models\Message;
class MessageRepository  extends BaseRepository
{
    public function __construct(Message $model){
        parent::__construct($model);
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
        $data = $this->model::where('journal_class_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher = $this->model::where('journal_class_id', $id)
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
        $data =  $this->model::where('journal_self_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher =  $this->model::where('journal_self_id', $id)
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
        $message = new  $this->model;
        $message->course_goal_id = $course_goal_id;
        $message->journal_goal_id = $journal_goal_id ?? null;
        $message->journal_class_id = $journal_class_id ?? null;
        $message->journal_self_id = $journal_self_id;
        $message->save();
        return $message;
    }
    

    public function getMessageDetailByCourseGoalId($id){
        $data =  $this->model::where('journal_self_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher =  $this->model::where('journal_self_id', $id)
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
    public function delete (int $id):bool{
        parent::delete($id);
    }
}