<?php
namespace App\Repositories;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;


class TeacherRepository extends Repository{
    public function __construct( Teacher $model){
        $this->model = $model;
    }
}
?>
