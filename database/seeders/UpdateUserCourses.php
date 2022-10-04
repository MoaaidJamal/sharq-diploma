<?php

namespace Database\Seeders;

use App\Models\UsersCourse;
use App\Models\UsersLecture;
use Illuminate\Database\Seeder;

class UpdateUserCourses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsersLecture::query()->whereHas('user')->whereHas('lecture')->each(function (UsersLecture $usersLecture) {
            UsersCourse::query()->updateOrCreate([
                'user_id' => $usersLecture->user_id,
                'course_id' => $usersLecture->lecture->course_id,
            ]);
        });
    }
}
