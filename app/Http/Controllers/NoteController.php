<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $note = Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return response()->json($note, 201);
    }

    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->get();
        return response()->json($notes, 200);
    }

    public function show($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($note, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->update($request->all());

        return response()->json($note, 200);
    }

    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->json(null, 204);
    }
}
