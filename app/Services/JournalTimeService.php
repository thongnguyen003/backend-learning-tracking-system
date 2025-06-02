<?php

namespace App\Services;

use App\Repositories\JournalTimeRepository;
use Carbon\Carbon;
use App\Services\CourseService;
use App\Models\Course;
use App\Models\Journal;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\Log;
class JournalTimeService extends BaseService
{
    public function __construct(JournalTimeRepository $repo){
        parent::__construct($repo);
    }

    public function getAllJournalTimes()
    {
        return $this->repository->getAll();
    }

     public function getById(int $id)
    {
        return parent::getById($id);
    }

    public function createJournalTime(array $data)
    {
        return $this->repository->create($data);
    }

    public function deleteJournalTime($id)
    {
        return $this->repository->delete($id);
    }

    public function getJournalTimesByCourseId($courseId)
    {
        return $this->repository->getByCourseId($courseId);
    }
    public function update(int $id, array $data){
        if (!empty($data['start_date'])){
            $start_date = Carbon::parse($data['start_date']);
            $end_date = Carbon::parse($data['end_date']);
            $end_date_week = $end_date->copy()->startOfWeek(Carbon::SUNDAY)->addWeeks();
            $next_date = $end_date_week->copy()->addDay();
            $convertDate = Carbon::parse($end_date->toDateString() . " " . $data['deadline']);
            if($start_date > $end_date){
                Log::info('Process Information', [
                    'start' => $start_date->toDateString(),
                    'end' => $end_date,
                ]);
                throw new \Exception("Start date cannot be earlier than end date.");
            }
            if($convertDate < Carbon::now() ){
                Log::info('Process Information', [
                    'time' => $convertDate->toDateString(),
                    'now' => Carbon::now(),
                ]);
                throw new \Exception("Deadline has already passed.");
            }
            $journalTime = $this->getById($id);
            $courseId = $journalTime->course_id;
            // $journal = Journal::where('start_date',$journalTime->start_date)->where('end_date',$journalTime->end_date)->whereHas('course_student',function($query) use ($courseId){
            //     $query->where('course_id',$courseId);
            // })->get();
            // if($journal){

            // }
            $courseService = new CourseService(new CourseRepository(new Course));
            $r = $courseService->update($courseId,['next_date'=>$next_date->toDateString()]);
        }
        return parent::update($id,$data);
    }
}