<?php

namespace App\Http\Controllers;

use App\Services\JournalTimeService;
use Illuminate\Http\Request;

class JournalTimeController extends Controller
{
    protected $service;

    public function __construct(JournalTimeService $service)
    {
        $this->service = $service;
    }


    public function getJournalTimesByCourseId($courseId)
    {
        $journalTimes = $this->service->getJournalTimesByCourseId($courseId);
        if ($journalTimes->isEmpty()) {
            return response()->json(['message' => 'No journal times found for this course'], 404);
        }
        return response()->json($journalTimes);
    }
}