<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
class StudentController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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
   public function updateProfile(Request $request, $id)
    {
        $data = $request->validate([
            'student_name' => 'required|string|max:50',
            'day_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'hometown' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        try {
            $student = $this->studentService->updateStudentProfile($id, $data);
            return response()->json(['message' => 'Student profile updated successfully', 'data' => $student], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
