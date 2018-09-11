<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Smeechos\TaskScheduler\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function can_create_task()
    {
//        $task = new Task;
//        $task->command = 'test:command';
//        $task->cron_id = '1';
//        $this->assertTrue($task->save());
        $task = factory(Task::class, 1)->create()->first();
        var_dump($task);
    }
}
