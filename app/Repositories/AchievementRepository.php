<?php
namespace App\Repositories;
use App\Models\Achievement;
class AchievementRepository  extends BaseRepository {
    public function __construct(Achievement $model){
        parent::__construct($model);  
    }
    public function getByStudentId($id){
        $result = $this->model::where('student_id',$id)
        ->with('images')
        ->get();
        return $result;
    }
    public function create(array $data){
        return parent::create($data);
    }
    public function delete(int $id){
        return parent::delete($id);
    }
}