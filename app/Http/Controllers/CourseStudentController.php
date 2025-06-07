<?php

namespace App\Http\Controllers;
use App\Services\CourseStudentService;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    protected CourseStudentService $service;

    public function __construct(CourseStudentService $service)
    {
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
        $data = $request->all();
        try {
            $result = $this->service->multifulStore($data);
            return response()->json($result);
        } catch (Exception $e){
            $error= "Lỗi" . $e->getMessage() ;
            return response()->json(['error'=>$error]);
        };
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
    public function destroy(string $id)
    {
        //
    }
}
