<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\JournalClassesService;
class JournalClassesController extends Controller
{
    protected $service;
    public function __construct(JournalClassesService $service){
        $this->service = $service;
    }
    public function index()
    {
        return response()->json($this->service->getAll());
    }
    public function show(string $id)
    {
        return response()->json($this->service->getById($id));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'description' => 'required|string',
            'assessment' => 'required|integer',
            'difficulty' => 'required|string',
            'plan' => 'required|string',
            'solution' => 'required|string',
        ]);
        return response()->json($this->service->create($data), 201);


    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'journal_id' => 'sometimes|exists:journals,id',
            'date' => 'sometimes|date',
            'topic' => 'sometimes|string',
            'description' => 'sometimes|string',
            'assessment' => 'sometimes|integer',
            'difficulty' => 'sometimes|string',
            'plan' => 'sometimes|string',
            'solution' => 'sometimes|string',
        ]);
        return response()->json($this->service->update($id, $data));
    }
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}