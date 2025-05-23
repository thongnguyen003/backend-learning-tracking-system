<?php
namespace App\Repositories;
use App\Models\Achievement;
class AchievementRepository  extends BaseRepository {
    public function __construct(Achievement $model){
        parent::__construct($model);  
    }
    protected function getByStudentId($id){
        $result = $this->model::where('student_id',$id)
        ->with('images')
        ->get();
        return $result;
    }
}