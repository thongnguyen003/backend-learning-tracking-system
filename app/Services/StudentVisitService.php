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

    public function getVisitCountsByClass($month = null)
    {
        $month = $month ?? Carbon::now()->format('Y-m');
        $year = Carbon::parse($month)->year;
        $monthNum = Carbon::parse($month)->month;

        return \DB::table('student_visits')
            ->join('students', 'student_visits.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.name as class_name', \DB::raw('count(student_visits.id) as visit_count'))
            ->whereYear('student_visits.visit_date', $year)
            ->whereMonth('student_visits.visit_date', $monthNum)
            ->groupBy('classes.name')
            ->get();
    }
}
