<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {
        $pulicNote = Note::with('sharedWith')->orderBy('title', 'asc')->where('is_public', true)->get();
        $notes = Note::with('sharedWith')->orderBy('title', 'asc')->where('user_id', Auth::id())->get();
        $users = User::get();
        return Inertia::render('Notes/ManageNote', compact('notes', 'users', 'pulicNote'));
    }

    public function store(Request $request)
    {
        Note::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_public' => $request->is_public ?? false,
        ]);
        return redirect()->route('notes.index')->with('success', 'Note created successfully');
    }

    public function show(Note $note)
    {
        if (!Gate::allows('view', $note)) {
            abort(403, 'Tidak ada akses.');
        }

        $note->load('comments.user', 'sharedWith');

        return Inertia::render('Notes/NoteDetail', compact('note'));
    }

    public function edit(Note $note)
    {
        return Inertia::render('Notes/EditNote', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $note->update($request->only('title', 'content', 'is_public'));
        return back()->with('success', 'Note update successfully!');;
    }

    public function togglePublic(Note $note)
    {
        $this->authorize('update', $note);
        $note->is_public = !$note->is_public;
        $note->save();
        return redirect()->route('notes.index')->with('success', 'Successfully set as public');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        if ($note->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully');
    }

    public function share(Note $note, Request $request)
    {
       $this->authorize('update', $note);

        $validated = $request->validate([
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $note->sharedWith()->sync($validated['user_ids']);

        return back()->with('success', 'Note shared successfully!');
    }

    public function comment(Note $note, Request $request)
    {
        $this->authorize('update', $note);

        $note->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commented !');;
    }
}
