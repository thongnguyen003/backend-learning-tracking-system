<?php
namespace App\Http\Controllers;
use App\Services\ClassService;
use Illuminate\Http\Request;

class ClassController extends Controller
{  
    protected $service;
    public function __construct(ClassService $service){
        $this->service = $service;
    }
    public function getClassByTeacherId($id){
        $result = $this->service->getClassDetailsByTeacherId($id);
        return response($result);
    }
}
