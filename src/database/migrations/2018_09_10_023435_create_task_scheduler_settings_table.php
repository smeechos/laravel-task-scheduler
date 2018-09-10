<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskSchedulerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_scheduler_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting');
            $table->string('type');
            $table->string('status');
            $table->timestamps();
        });

        DB::table('task_scheduler_settings')->insert(
            array(
                'setting'   => 'logging',
                'type'      => 'boolean',
                'status'    => 'disabled'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_scheduler_settings');
    }
}
