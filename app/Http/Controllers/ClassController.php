<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClassService;

class ClassController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index()
    {
        try {
            $classes = $this->classService->getAllClasses();
            return response()->json([
                'status' => 'success',
                'data' => $classes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
            'quantity' => 'nullable|integer|min:0',
            'state' => 'nullable|integer|in:0,1,2'
        ]);

        $newClass = $this->classService->createClass($validated);

        return response()->json([
            'success' => true,
            'message' => 'Class created successfully',
            'class' => $newClass
        ], 201);
    }
       public function getClassByTeacherId($id){
        return $result = $this->classService->getClassDetailsByTeacherId($id);
    }
   public function getClassByClassId($id)
    {
        $class = $this->classService->getClassById($id);

        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $class
        ]);
    }

}

