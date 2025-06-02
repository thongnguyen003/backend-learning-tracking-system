<?php
namespace App\Services;
use Carbon\Carbon;
use App\Repositories\JournalRepository;
use App\Services\JournalTimeService;
use App\Repositories\JournalTimeRepository;
use App\Models\JournalTime;
class JournalService extends BaseService {
    public function __construct(JournalRepository $repo){
        parent::__construct($repo);
    }
    public function getJournalsDetailsByCourseStudentId(int $id){
        return $this->repository->getJournalsDetailByCourseStudentId($id);
    }
    public function create(array $data){
        $journalTimeService = new JournalTimeService(new JournalTimeRepository(new JournalTime));
        $journalTime = $journalTimeService->getById($data['journalTimeId']);
        $currentDate = Carbon::now();
        $array = [
        'course_student_id'=>$data['course_student_id'],
        'start_day'=>$journalTime->start_date,
        'end_day'=>$journalTime->end_date,'open_date'=>$currentDate,
        'deadline'=>$journalTime->deadline,
        'accept_deadline'=>$journalTime->accept_deadline,
        ];
        return parent::create($array);
    }
}