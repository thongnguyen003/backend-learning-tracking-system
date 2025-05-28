<?php

namespace App\Http\Controllers;

use App\Services\StudentVisitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentVisitController extends Controller
{
    protected $studentVisitService;

    public function __construct(StudentVisitService $studentVisitService)
    {
        $this->studentVisitService = $studentVisitService;
    }

    public function trackVisit(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user instanceof \App\Models\Student) {
            $this->studentVisitService->trackVisit($user->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Visit recorded'
            ], 200);
        }
        return response()->json(['error' => 'Only students can track visits'], 403);
    }

    public function getVisitDates(Request $request, $studentId): JsonResponse
    {
        $user = $request->user();
        if ($user instanceof \App\Models\Admin && $user->role === 'admin') {
            $month = $request->query('month', now()->format('Y-m'));
            $visitDates = $this->studentVisitService->getStudentVisitDates($studentId, $month);
            return response()->json([
                'status' => 'success',
                'data' => $visitDates
            ], 200);
        } elseif ($user instanceof \App\Models\Teacher) {
            $student = \App\Models\Student::findOrFail($studentId);
            $class = \App\Models\Classes::where('teacher_id', $user->id)
                ->where('id', $student->class_id)
                ->first();
            if (!$class) {
                return response()->json(['error' => 'Unauthorized: Teacher not assigned to this student\'s class'], 403);
            }
            $month = $request->query('month', now()->format('Y-m'));
            $visitDates = $this->studentVisitService->getStudentVisitDates($studentId, $month);
            return response()->json([
                'status' => 'success',
                'data' => $visitDates
            ], 200);
        } elseif ($user instanceof \App\Models\Student && $user->id == $studentId) {
            $month = $request->query('month', now()->format('Y-m'));
            $visitDates = $this->studentVisitService->getStudentVisitDates($studentId, $month);
            return response()->json([
                'status' => 'success',
                'data' => $visitDates
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}