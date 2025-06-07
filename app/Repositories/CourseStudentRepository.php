<?php
namespace App\Repositories;
use App\Models\CourseStudent;
class CourseStudentRepository extends BaseRepository{
    public function __construct(CourseStudent $model){
        parent::__construct($model);
    }
    public function create($array){
        parent::create($array);
    }
}