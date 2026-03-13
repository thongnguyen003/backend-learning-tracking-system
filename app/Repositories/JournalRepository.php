<?php
namespace App\Repositories;
use App\Models\Journal;
use App\Models\CourseStudent;
class JournalRepository extends BaseRepository{
    public function __construct(Journal $model){
        parent::__construct($model);
    }
    public function getJournalsDetailByCourseStudentId(int $id){
        $journals = Journal::where('course_student_id', $id)
        ->with(['journalClasses', 'journalSelfs', 'journalGoals'])
        ->get();
        $journalTimes = CourseStudent::where('id', $id)
        ->with('course.journalTimes')
        ->first();
        $journalTimesConvert = [];
        if(!empty($journalTimes)){
            $journalTimesConvert = $journalTimes->course;
        }
        return $data= ['journals'=>$journals,'journalTimes'=>$journalTimesConvert];
    }
    public function create(array $data) {
        return parent::create($data);
    }
    
}