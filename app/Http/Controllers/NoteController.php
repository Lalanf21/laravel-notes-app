<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('comments', 'sharedUsers')->where('user_id', Auth::id())->get();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $note = Note::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_public' => $request->is_public ?? false,
        ]);
        return response()->json($note);
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);
        // Izinkan akses jika: pemilik, note public, atau termasuk user yang dibagikan
        if (
            $note->user_id === Auth::id() ||
            $note->is_public ||
            $note->sharedUsers()->where('user_id', Auth::id())->exists()
        ) {
            return response()->json($note->load('comments', 'sharedUsers'));
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function update(Request $request, Note $note)
    {
         $this->authorize('update', $note);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $note->update($request->only('title', 'content', 'is_public'));
        return response()->json($note);
    }

    public function destroy(Note $note)
    {
         $this->authorize('delete', $note);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $note->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function share(Note $note, Request $request)
    {
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $note->sharedUsers()->syncWithoutDetaching([$user->id]);
        return response()->json(['message' => 'Note shared']);
    }

    public function comment(Note $note, Request $request)
    {
        if (
            $note->user_id !== Auth::id() &&
            !$note->is_public &&
            !$note->sharedUsers()->where('user_id', Auth::id())->exists()
        ) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment = $note->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($comment);
    }

    public function publicNotes()
    {
        return response()->json(Note::where('is_public', true)->with('user')->get());
    }
}
