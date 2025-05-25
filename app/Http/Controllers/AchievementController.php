<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AchievementService;

class AchievementController extends Controller
{
    protected $service;
    public function __construct(AchievementService $service){
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
        $infoAchievement['student_id']= $request->input('student_id');
        $infoAchievement['title']= $request->input('title');
        $infoAchievement['description']= $request->input('description');
        $links = $request->input('links');
        $array = ['infoAchievement'=>$infoAchievement,'links'=>$links];
        try {
            
           $this->service->create($array);

            return response()->json([
                'message' => 'Add  successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Add  failed: ' . $e->getMessage()
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
    public function getByStudentId($studentId){
        return $this->service->getByStudentId($studentId);
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
        $infoAchievement['title']= $request->input('title');
        $infoAchievement['description']= $request->input('description');
        try {
            
           $this->service->update($id,$infoAchievement);

            return response()->json([
                'message' => 'Update  successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Update  failed: ' . $e->getMessage()
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->service->delete($id);
    }
    public function delete(int $id){
        return parent::delete($id);
    }
}
