<?php

namespace App\Services;

use App\Models\StudentVisit;
use Carbon\Carbon;

class StudentVisitService
{
    public function trackVisit($studentId)
    {
        $today = Carbon::today()->toDateString();
        StudentVisit::updateOrCreate(
            ['student_id' => $studentId, 'visit_date' => $today],
            ['visit_date' => $today]
        );
    }

    public function getStudentVisitDates($studentId, $month = null)
    {
        $month = $month ?? Carbon::now()->format('Y-m');
        $year = Carbon::parse($month)->year;
        $monthNum = Carbon::parse($month)->month;

        return StudentVisit::where('student_id', $studentId)
            ->whereYear('visit_date', $year)
            ->whereMonth('visit_date', $monthNum)
            ->get()
            ->map(function ($visit) {
                return Carbon::parse($visit->visit_date)->format('Y-m-d');
            })
            ->toArray();
    }
}