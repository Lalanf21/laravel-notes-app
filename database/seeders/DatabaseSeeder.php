<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run(): void
    {
        User::factory()->count(3)->create()->each(function ($user) {
            $notes = Note::factory()->count(2)->create([
                'user_id' => $user->id,
                'is_public' => fake()->boolean(),
            ]);

            foreach ($notes as $note) {
                // Share note
                $otherUsers = User::where('id', '!=', $user->id)->get();
                if ($otherUsers->count()) {
                    $note->sharedWith()->attach($otherUsers->random()->id);
                }

                // Add comments
                Comment::factory()->count(2)->create([
                    'note_id' => $note->id,
                    'user_id' => $user->id
                ]);
            }

        });
    }

}
