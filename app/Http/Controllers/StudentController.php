<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(): JsonResponse
    {
        $user = request()->user();
        if (!($user instanceof \App\Models\User && $user->role === 'admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $students = $this->studentService->getAllStudents();
        return response()->json([
            'status' => 'success',
            'data' => $students
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $user = request()->user();
        if (!($user instanceof \App\Models\User && $user->role === 'admin') && !($user instanceof \App\Models\Teacher)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $student = $this->studentService->findById($id);
        return response()->json([
            'status' => 'success',
            'data' => $student
        ], 200);
    }

    public function showStudentsByClassId($classId): JsonResponse
    {
        $user = request()->user();
        if ($user instanceof \App\Models\User && $user->role === 'admin') {
            $students = $this->studentService->getStudentsByClassId($classId);
            return response()->json([
                'status' => 'success',
                'data' => $students
            ], 200);
        } elseif ($user instanceof \App\Models\Teacher) {
            $class = \App\Models\Classes::where('teacher_id', $user->id)->where('id', $classId)->first();
            if (!$class) {
                return response()->json(['error' => 'Unauthorized: Teacher not assigned to this class'], 403);
            }
            $students = $this->studentService->getStudentsByClassId($classId);
            return response()->json([
                'status' => 'success',
                'data' => $students
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function changePassword(Request $request, $id): JsonResponse
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

    public function updateProfile(Request $request, $id): JsonResponse
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
}