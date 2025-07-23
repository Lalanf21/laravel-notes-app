<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoteUser extends Pivot
{
    protected $table = 'note_user_shares';
    public $timestamps = true;

    protected $fillable = ['note_id', 'user_id'];
}
