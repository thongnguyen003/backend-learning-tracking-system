<?php
namespace App\Repositories;
use App\Models\Journal;
class JournalRepository extends Repository{
    public function __construct(Journal $model){
        $this->model = $model;
    }
    public function getJournalsDetailByCourseStudentId(int $id){
        $journals = Journal::where('course_student_id', $id)
        ->with(['journalClasses', 'journalSelfs', 'journalGoals'])
        ->get();
        return response()->json($journals);
    }
    
}