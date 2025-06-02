<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ClassTeacherService;
use Illuminate\Http\Request;

class ClassTeacherController extends Controller
{
    protected $service;

    public function __construct(ClassTeacherService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        return response()->json($this->service->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Kiểm tra xem giáo viên đã có trong lớp chưa
        $existingRecord = $this->service->getByClassAndTeacher($data['class_id'], $data['teacher_id']);
        if ($existingRecord) {
            return response()->json(['message' => 'Teacher already exists in this class.'], 409);
        }

        // Nếu chưa tồn tại, thêm giáo viên vào lớp
        return response()->json($this->service->create($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'class_id' => 'sometimes|required|exists:classes,id',
        ]);
        return response()->json($this->service->update($id, $data));
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Logic để xóa giáo viên khỏi lớp
        $classTeacher = $this->service->getByClassAndTeacher($data['class_id'], $data['teacher_id']);
        if ($classTeacher) {
            $this->service->delete($classTeacher->id);
            return response()->json(['message' => 'Teacher removed from class successfully.'], 200);
        }

        return response()->json(['message' => 'Teacher not found in this class.'], 404);
    }
    public function showTeachersByClassId($classId)
    {
        return response()->json($this->service->getTeachersByClassId($classId));
    }
    public function showClassesByTeacherId($teacherId)
    {
        // Lấy danh sách lớp theo teacher_id
        $classes = $this->service->getClassesByTeacherId($teacherId);
        
        // Kiểm tra xem có lớp nào không
        if ($classes->isEmpty()) {
            return response()->json(['message' => 'No classes found for this teacher.'], 404);
        }

        return response()->json($classes);
    }
}