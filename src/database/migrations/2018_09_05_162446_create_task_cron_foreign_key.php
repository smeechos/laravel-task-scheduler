<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskCronForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_scheduler_tasks', function (Blueprint $table) {
            $table->foreign('cron_id')->references('id')->on('task_scheduler_crons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_scheduler_tasks', function (Blueprint $table) {
            $table->dropForeign('task_scheduler_tasks_cron_id_foreign');
        });
    }
}
