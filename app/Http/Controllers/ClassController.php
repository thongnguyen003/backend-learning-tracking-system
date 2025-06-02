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
        $user = request()->user();
        \Log::info('User data:', ['user' => $user]);
        if (!($user instanceof \App\Models\Admin && $user->role === 'admin')) { 
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        try {
            $classes = $this->classService->getAllClasses();
            return response()->json([
                'status' => 'success',
                'data' => $classes,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching classes:', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $user = request()->user();
        if (!($user instanceof \App\Models\Admin && $user->role === 'admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
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

    public function getClassByTeacherId($id)
    {
        // $user = request()->user();
        // if (!($user instanceof \App\Models\Teacher && $user->id == $id)) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        
        $result = $this->classService->getClassDetailsByTeacherId($id);
        return response()->json([
            'status' => 'success',
            'data' => $result
        ], 200);
    }

    public function getClassByClassId($id)
    {
        $user = request()->user();
        if (!($user instanceof \App\Models\Admin && $user->role === 'admin') && !($user instanceof \App\Models\Teacher)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
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
        ], 200);
    }
}