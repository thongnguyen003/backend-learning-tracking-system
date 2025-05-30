<?php

namespace App\Services;

use App\Repositories\JournalTimeRepository;
use Carbon\Carbon;
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

    public function getJournalTimeById($id)
    {
        return $this->repository->getById($id);
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
        }
        return parent::update($id,$data);
    }
}