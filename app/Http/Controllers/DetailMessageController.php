<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DetailMessageService;
class DetailMessageController extends Controller
{
    protected $service;
    public function __construct(DetailMessageService $service){
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $message_id = $request->input('message_id');
        $student_id = $request->input('student_id');
        $teacher_id = $request->input('teacher_id');
        $content = $request->input('content');
        try {
            
            $this->service->store($message_id,$student_id,$teacher_id,$content);

            return response()->json([
                'message' => 'Add detail message successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Add detail message failed: ' . $e->getMessage()
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
    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $this->service->updateMessage($data,$id);
        return response()->json([
            'success' => true,
            'message' => 'Message updated successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully',
        ], 200);
    }
}
