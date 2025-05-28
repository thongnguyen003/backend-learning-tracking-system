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

    public function destroy($id)
    {
        return response()->json($this->service->delete($id));
    }
    public function showTeachersByClassId($classId)
    {
        return response()->json($this->service->getTeachersByClassId($classId));
    }
}