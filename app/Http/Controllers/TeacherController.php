<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;  // Import model Teacher
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(int $id)
    {
        $teacher = $this->teacherService->findById($id);
        return response()->json($teacher);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function changePassword(Request $request, $id)
    {
        $id = (int) $id; // Lấy ID từ URL
        $data = $request->all();

        try {
            if (!$id) {
                return response()->json(['error' => 'Teacher ID is missing'], 400);
            }

            return $this->teacherService->changePassword($id, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateProfile(Request $request, $id)
{
    $data = $request->validate([
        'teacher_name' => 'required|string|max:50',
        'day_of_birth' => 'nullable|date',
        'gender' => 'required|in:male,female,other',
        'hometown' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'subject_id' => 'nullable|integer|exists:subjects,id',
        'password' => 'nullable|string|min:6',
    ]);

    try {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $teacher = $this->teacherService->updateTeacherProfile($id, $data);
        return response()->json(['message' => 'Teacher profile updated successfully', 'data' => $teacher], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

}
