<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;
    public function show(int $id)
    {
        $teacher = $this->teacherService->findById($id);
        return response()->json($teacher);
    }
    public function __construct(TeacherService $teacherService){
        $this->teacherService = $teacherService;
    }
}
