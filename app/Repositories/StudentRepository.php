<?php
namespace App\Repositories;
use App\Models\Student;
class StudentRepository extends Repository{
    public function __construct(Student $model){
        $this->model = $model;
    }
    public function login(array $studentData){
        $student = $this->model->where('email',$studentData['email']);
        if($student && Hash::check($studentData['password'],$student->password)){
            return response()->json($student);
        }else{
            return response()->json(['error' => 'Unexited Account'], 401);
        }
    }
    public function getStudentById(int $id){
        $student = $this->model->find($id);
        if($student){
            return response()->json($student);
        }else{
            return response()->json(['error' => 'Unexited Account'], 401);
        }
    }
}