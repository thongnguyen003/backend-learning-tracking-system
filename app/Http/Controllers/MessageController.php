<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
class MessageController extends Controller
{
    protected $service;
    public function __construct(MessageService $service){
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function getMessageDetailByJournalGoalId($id){
        return $this->service->getMessageDetailByJournalGoalId($id);
    }

    public function getMessageDetailByCourseGoalId($id){
        return $this->service->getMessageDetailByCourseGoalId($id);
    }
    

    public function getMessageDetailByJournalClassId($id){
        return $this->service->getMessageDetailByJournalClassId($id);
    }
    public function getMessageDetailByJournalSelfId($id){
        return $this->service->getMessageDetailByJournalSelfId($id);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course_goal_id = $request->input('course_goal_id');
        $student_id = $request->input('student_id');
        $teacher_id = $request->input('teacher_id');
        $view_teacher_id = $request->input('view_teacher_id');
        $journal_goal_id = $request->input('journal_goal_id');
        $journal_class_id = $request->input('journal_class_id');
        $journal_self_id = $request->input('journal_self_id');
        $content = $request->input('content');
        try {
            
            $this->service->store($course_goal_id,$journal_goal_id,$journal_class_id,$journal_self_id,$student_id,$teacher_id,$content,$view_teacher_id);

            return response()->json([
                'message' => 'Add  message successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Add  message failed: ' . $e->getMessage()
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);
    }
}
