<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function sharedNotes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_user_shares', 'user_id', 'note_id')->using(NoteUser::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
