<?php
namespace App\Repositories;
use App\Models\Message;
use App\Models\JournalSelf;
use App\Models\JournalClasses;
use App\Models\JournalGoal;
use App\Models\CourseGoal;
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
        $teacher = JournalGoal::where('id', $id)
        ->with("journal.course_student.course.class.class_teachers.teacher")
        ->first();
        $student =  JournalGoal::where('id', $id)
         ->with("journal.course_student.student")
        ->first();
        if ($student ) {
            $studentData = $student->journal
                ->course_student->student;
        } else {
            $studentData = null; 
        }
        if ($teacher ) {
            $teacherData = $teacher->journal
                ->course_student->course->class
                ->class_teachers;
        }  else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data,'student'=>$studentData];
        
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
        $teacher = JournalClasses::where('id', $id)
        ->with("journal.course_student.course.class.class_teachers.teacher")
        ->first();
        $student =  JournalClasses::where('id', $id)
         ->with("journal.course_student.student")
        ->first();
        if ($student ) {
            $studentData = $student->journal
                ->course_student->student;
        } else {
            $studentData = null; 
        }
        if ($teacher ) {
            $teacherData = $teacher->journal
                ->course_student->course->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data,'student'=>$studentData];
        
        return response()->json($result);
    }
    public function getMessageDetailByJournalSelfId($id){
        $data =  $this->model::where('journal_self_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->with('student')->with('teacher');
        }])
        ->get();
        
        $teacher =  JournalSelf::where('id', $id)
         ->with("journal.course_student.course.class.class_teachers.teacher")
        ->first();
        $student =  JournalSelf::where('id', $id)
         ->with("journal.course_student.student")
        ->first();
        if ($student ) {
            $studentData = $student->journal
                ->course_student->student;
        } else {
            $studentData = null; 
        }
        if ($teacher ) {
            $teacherData = $teacher->journal
                ->course_student->course->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data,'student'=>$studentData];
        
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
        $data = $this->model::where('course_goal_id',$id)
        ->with(['detail_messages' => function ($query) {
        $query->whereNotNull('student_id')
              ->orWhereNotNull('teacher_id') 
              ->with(['student', 'teacher']);
        }])
        ->get();
        $teacher = CourseGoal::where('id', $id)
        ->with("course_student.course.class.class_teachers.teacher")
        ->first();
        $student =  CourseGoal::where('id', $id)
         ->with("course_student.student")
        ->first();
        if ($student ) {
            $studentData = $student
                ->course_student->student;
        } else {
            $studentData = null; 
        }
        if ($teacher ) {
            $teacherData = $teacher
                ->course_student->course->class
                ->class_teachers;
        } else {
            $teacherData = null; 
        }
        $result = ['teacher'=>$teacherData,'message'=>$data,'student'=>$studentData];
        
        return response()->json($result);

    }
    public function delete (int $id):bool{
        parent::delete($id);
    }
}