<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->get()->each(function ($user) {
            $name = $user->name ? '{"ar": "' . $user->name . '", "en": "' . $user->name . '"}' : null;
            $bio = $user->bio ? '{"ar": "' . $user->bio . '", "en": "' . $user->bio . '"}' : null;
            $position = $user->position ? '{"ar": "' . $user->position . '", "en": "' . $user->position . '"}' : null;
            $work = $user->work ? '{"ar": "' . $user->work . '", "en": "' . $user->work . '"}' : null;
            $study = $user->study ? '{"ar": "' . $user->study . '", "en": "' . $user->study . '"}' : null;
            User::query()->where('id', $user->id)->update([
                'name' => $name,
                'bio' => $bio,
                'position' => $position,
                'work' => $work,
                'study' => $study,
            ]);
        });
    }
}
