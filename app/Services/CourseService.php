<?php
namespace App\Services;
use App\Repositories\CourseRepository;
use App\Services\CourseStudentService;
use App\Repositories\CourseStudentRepository;
use App\Models\CourseStudent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class CourseService extends BaseService {
    public function __construct(CourseRepository $repo){
        parent::__construct($repo);
    }
    public function getCoursesDetailsByStudentId(int $studentId){
        return $this->repository->getCoursesDetailsByStudentId($studentId);
    }
    public function getCoursesDetailsByClassId(int $studentId){
        return $this->repository->getCoursesDetailsByClassId($studentId);
    }
    public function getCoursesDetailsByCourseId(int $courseId){
        return $this->repository->getCourseDetailsByCourseId($courseId);
    }
    public function create ($data){
        $array = $data['array'];
        $course =$this->repository->create($array);
        $course_id = $course->id;
        if($course_id){
            if($data['chooseAllStudent']){
                $courseStudentService = new CourseStudentService(new CourseStudentRepository(new CourseStudent));
                $result = $courseStudentService->addStudentIntoCourseByClass($array['class_id'],$course_id);
                return ['mes'=>"ok, tôi ở đây","res"=>$result];
            }
            return true;
        }
        return false;
    }
    public function update(int $id, array $data){
        if (!empty($data['start_date'])){
            $course = parent::getById($id);
            $start_date = Carbon::parse($course->start_date);
            $end_date = $start_date->copy()->startOfWeek(Carbon::SUNDAY)->addWeeks();
            $convertDate = Carbon::parse($end_date->toDateString() . " " . $data['next_deadline']);
            if (!empty($data['next_date'])){
                $course = parent::getById($id);
                $start_date = Carbon::parse($course->start_date);
                $end_date = $start_date->copy()->startOfWeek(Carbon::SUNDAY)->addWeeks();
                $convertDate = Carbon::parse($end_date->toDateString() . " " . $course->next_deadline);
                if($start_date > Carbon::parse($data['next_date'])){
                    Log::info('Process Information', [
                        'start' => $start_date->toDateString(),
                        'end' => $end_date,
                        'new_date' =>$data['next_date'],
                    ]);
                    throw new \Exception("Start date cannot be earlier than next date.");
                }
                if($convertDate < Carbon::now() ){
                    Log::info('Process Information', [
                        'time' => $convertDate->toDateString(),
                        'now' => Carbon::now(),
                    ]);
                    throw new \Exception("Deadline has already passed.");
                }
            }
        }
        return parent::update($id,$data);
    }
}