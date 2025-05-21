<?php
namespace App\Http\Controllers;
use App\Services\JournalSelfService;
use Illuminate\Http\Request;
class JournalSelfController extends Controller
{
    protected $journalSelfService;


    public function __construct(JournalSelfService $journalSelfService)
    {
        $this->journalSelfService = $journalSelfService;
    }


    public function index()
    {
        $data = $this->journalSelfService->getAll();
        return response()->json($data, 200);
    }


    public function show($id)
    {
        $item = $this->journalSelfService->getById($id);
        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($item, 200);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'date' => 'required',
            'topic' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required',
            'resources' => 'required|string',
            'activity' => 'required|string',
            'concentration' => 'required',
            'follow_plan' => 'required',
            'evaluation' => 'required|string',
            'reinforcing_learning' => 'required|string',
            'notes' => 'nullable|string',
        ]);


        $item = $this->journalSelfService->create($data);
        return response()->json($item, 201);
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'date' => 'required',
            'topic' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required',
            'resources' => 'required|string',
            'activity' => 'required|string',
            'concentration' => 'required',
            'follow_plan' => 'required',
            'evaluation' => 'required|string',
            'reinforcing_learning' => 'required|string',
            'notes' => 'nullable|string',
        ]);


        $updatedItem = $this->journalSelfService->update($id, $data);


        if (!$updatedItem) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($updatedItem, 200);
    }


    public function destroy($id)
    {
        $deleted = $this->journalSelfService->delete($id);


        if (!$deleted) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
?>

