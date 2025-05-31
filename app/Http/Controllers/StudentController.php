<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;  // Import model Student
use App\Services\StudentService;
class StudentController extends Controller{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function show(int $id)
    {
        $student = $this->studentService->findById($id);
        return response()->json($student);
    }

    public function changePassword(Request $request, $id)
    {
        $id = (int) $id;
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

    public function updateProfile(Request $request, $id)
    {
        $data = $request->validate([
            'student_name' => 'required|string|max:50',
            'day_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'hometown' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        try {
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $student = $this->studentService->updateStudentProfile($id, $data);

            return response()->json(['message' => 'Student profile updated successfully', 'data' => $student], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function showStudentsByClassId($classId)
    {
        $students = $this->studentService->getStudentsByClassId($classId);
        return response()->json($students);
    }
    public function showStudentsByCourseId($id)
    {
        $students = $this->studentService->showStudentsByCourseId($id);
        
        return $students; // Trả về danh sách sinh viên dưới dạng JSON
    }
}
 