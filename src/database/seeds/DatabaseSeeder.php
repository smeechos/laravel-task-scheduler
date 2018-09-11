<?php

namespace Smeechos\TaskScheduler\Database\Seeds;

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
        $this->call([
            CronsTableSeeder::class,
            TasksTableSeeder::class
        ]);
    }
}
