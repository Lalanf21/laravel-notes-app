<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Models\Note;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/notes/create', fn () => Inertia::render('Notes/CreateNote'));
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::put('/notes/{note}/toggle-public', [NoteController::class, 'togglePublic'])->name('notes.toggle-public');
    Route::post('/notes/{note}/share', [NoteController::class, 'share'])->name('notes.share');
    Route::post('/notes/{note}/comment', [NoteController::class, 'comment'])->name('notes.comment');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth/Login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

require __DIR__.'/auth.php';
