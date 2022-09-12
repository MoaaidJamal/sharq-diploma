<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'type' => 1,
            'password' => bcrypt(123456),
        ]);
        Setting::query()->create([
            'email' => '',
            'mobile' => '',
        ]);
    }
}
