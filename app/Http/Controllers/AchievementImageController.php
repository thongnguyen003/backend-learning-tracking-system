<?php

namespace App\Http\Controllers;
use App\Services\AchievementImageService;
use Illuminate\Http\Request;

class AchievementImageController extends Controller
{
    protected $service;
    public function __construct(AchievementImageService $service){
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $info['link']= $request->input('link');
        $info['achievement_id']= $request->input('achievement_id');
        try {
            
           $this->service->create($info);

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
        $info['link']= $request->input('link');
        try {
            
           $this->service->update($id,$info);

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
    public function destroy(int $id)
    {
        $this->service->delete($id);
    }
}
