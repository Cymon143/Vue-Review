<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Subject::factory(60)->create();
        \App\Models\Section::factory(10)->create();
        \App\Models\Major::factory(7)->create();
    }
}
