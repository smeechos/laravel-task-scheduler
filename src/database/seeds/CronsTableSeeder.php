<?php

namespace Smeechos\TaskScheduler\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CronsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crons = [
            '* * * * *' => 'Every minute',
            '*/5 * * * *' => 'Every 5 minutes',
            '0 0 * * *' => 'Everyday at 12:00 AM'
        ];

        foreach ( $crons as $key => $value ) {
            $expression = DB::table('crons')->where('expression', '=', $key)->first();
            if ( empty($expression) ) {
                DB::table('crons')->insert([
                    'expression'    => $key,
                    'description'   => $value,
                    'created_at'    => date( "Y-m-d H:i:s"),
                    'updated_at'    => date( "Y-m-d H:i:s"),
                ]);
            }
        }
    }
}
