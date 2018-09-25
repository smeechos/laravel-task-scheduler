<?php

namespace Smeechos\TaskScheduler\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Smeechos\TaskScheduler\Models\Cron;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crons = Cron::all();
        $count = 0;
        foreach ( $crons as $cron ) {
            if ( $count === 0 ) {
                DB::table('task_scheduler_tasks')->insert([
                    'command'   => 'example:command',
                    'cron_id'   => $cron->id,
                    'created_at'    => date( "Y-m-d H:i:s"),
                    'updated_at'    => date( "Y-m-d H:i:s"),
                ]);
                $count++;
            }
        }
    }
}
