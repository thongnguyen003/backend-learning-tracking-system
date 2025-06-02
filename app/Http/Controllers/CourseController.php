<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use Illuminate\Support\Facades\Response;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;
    public function __construct(CourseService $service){
        $this->service = $service;
    }
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
        $array['course_name']= $request->input('course_name');
        $chooseAllStudent = $request->input('chooseAllStudent');
        $array['start_day'] = $request->input('start_day');
        $array['end_day'] = $request->input('end_day');
        $array['class_id'] = $request->input('class_id');
        $array['teacher_id'] = $request->input('teacher_id');
        $data = ['array'=>$array,'chooseAllStudent'=>$chooseAllStudent];
        try {
            $result = $this->service->create($data);
            return response()->json($result);
        } catch (Exception $e){
            $error= "Lỗi" . $e->getMessage() . "code" . $e->getCode() . "file" . $e->getFile() . "line" . $e->getLine();
            return response()->json(['error'=>$error]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function getCourseByStudentId($id){
        $result = $this->service->getCoursesDetailsByStudentId($id);
        return response()->json($result);
    }
    public function getCourseByClassId($id){
        $result = $this->service->getCoursesDetailsByClassId($id);
        return response()->json($result);
    }
    public function getCourseByCourseId($id){
        try{
            $result =  $this->service->getCoursesDetailsByCourseId($id);
            return response()->json($result);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Add  message failed: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            $result = $this->service->update($id, $data);
            return response()->json($result);
        } catch (Exception $e){
            $error= "Lỗi" . $e->getMessage() ;
            return response()->json(['error'=>$error]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}