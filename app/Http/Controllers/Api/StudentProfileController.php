<?php

namespace App\Http\Controllers\Api;
use App\Models\Student; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class StudentProfileController extends Controller
{
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'day_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'hometown' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Lưu ý: nếu bạn muốn hash mật khẩu:
        $validated['password'] = bcrypt($validated['password']);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    public function show($id)
    {
        return response()->json(Student::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(null, 204);
    }
}

