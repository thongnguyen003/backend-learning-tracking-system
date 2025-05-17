<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;  // Import model Student
use App\Services\StudentService;
class StudentController extends Controller
{
    protected $studentService;  
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    public function changePassword(Request $request, $id)
    {
        $id = (int) $id; // Lấy ID từ URL
        $data = $request->all();

        try {
            if (!$id) {
                return response()->json(['error' => 'Student ID is missing'], 400);
            }

            return $this->studentService->changePassword($id, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
