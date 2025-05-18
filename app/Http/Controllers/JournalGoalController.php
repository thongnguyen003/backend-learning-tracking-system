<?php
namespace App\Http\Controllers;

use App\Services\JournalGoalService;
use Illuminate\Http\Request;

class JournalGoalController extends Controller
{
    protected $service;

    public function __construct(JournalGoalService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllGoals());
    }

    public function show($id)
    {
        $goal = $this->service->getGoalById($id);
        return $goal ? response()->json($goal) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => 'required|integer',
            'title' => 'nullable|string',
            'state' => 'integer',
            'date' => 'nullable|date',
        ]);

        $goal = $this->service->createGoal($validated);
        return response()->json($goal, 201);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'journal_id' => 'required|integer',
            'title' => 'nullable|string',
            'state' => 'integer',
            'date' => 'nullable|date',
        ]);

        \Log::info('Updating goal with data: ', $validated); // Log the data

        // Check if the goal exists
        $goal = $this->service->getGoalById($id);
        if (!$goal) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // Update the goal
        $updatedGoal = $this->service->updateGoal($id, $validated);
        return response()->json($updatedGoal);
    }

    public function destroy($id)
    {
        $this->service->deleteGoal($id);
        return response()->json(null, 204);
    }
}