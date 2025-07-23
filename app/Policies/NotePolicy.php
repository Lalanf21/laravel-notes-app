<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;

class NotePolicy
{
    public function view(User $user, Note $note): bool
    {
        return $note->user_id === $user->id ||
               $note->is_public ||
               $note->sharedUsers()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }

    public function delete(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }
}
