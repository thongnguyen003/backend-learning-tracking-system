<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CourseRequest; // Import the new request class

class CourseController extends Controller
{
    protected CourseService $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $courses = $this->service->getAll();
        return response()->json($courses);
    }

    public function show(int $id): JsonResponse
    {
        $course = $this->service->getById($id);
        if ($course) {
            return response()->json($course);
        }
        return response()->json(['message' => 'Course not found'], 404);
    }

    public function store(CourseRequest $request): JsonResponse
    {
        $data = $request->validated();
        $course = $this->service->create($data);
        return response()->json($course, 201);
    }

    public function update(CourseRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();  // Use validated data from the request
        $course = $this->service->update($id, $data);
        if ($course) {
            return response()->json($course);
        }
        return response()->json(['message' => 'Course not found or update failed'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'Course deleted successfully']);
        }
        return response()->json(['message' => 'Course not found or delete failed'], 404);
    }
}
