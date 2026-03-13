<?php

namespace App\Http\Controllers;

use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index()
    {
        return response()->json($this->subjectService->getAllSubjects());
    }

    public function show($id)
    {
        $subject = $this->subjectService->getSubject($id);
        return $subject ? response()->json($subject) : response()->json(['message' => 'Subject not found'], 404);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:50']);
        $subject = $this->subjectService->createSubject($request->all());
        return response()->json($subject, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:50']);
        $subject = $this->subjectService->updateSubject($id, $request->all());
        return $subject ? response()->json($subject) : response()->json(['message' => 'Subject not found'], 404);
    }

    public function destroy($id)
    {
        return $this->subjectService->deleteSubject($id) ? response()->json(['message' => 'Subject deleted']) : response()->json(['message' => 'Subject not found'], 404);
    }
}