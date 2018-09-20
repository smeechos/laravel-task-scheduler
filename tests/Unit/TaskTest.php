<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Smeechos\TaskScheduler\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that a model can be created.
     *
     * @return void
     * @test
     */
    public function can_create_task()
    {
        $task = factory(Task::class, 1)->make()->first();
        $this->assertInstanceOf(Task::class, $task);
    }

    /**
     * Test that a model can be updated.
     *
     * @return void
     * @test
     */
    public function can_update_task()
    {
        $task = factory(Task::class, 1)->make()->first();
        $command = $task->command;
        $task->command = 'updated:command';
        $task->save();
        $this->assertNotEquals($command, $task->command);
    }

    /**
     * Test that a model can be deleted.
     *
     * @return void
     * @test
     */
    public function can_delete_task()
    {
        $task = factory(Task::class, 1)->make()->first();
        $id = $task->id;
        $task->delete();
        $this->assertEmpty(Task::where('id', '=', $id)->first());
    }
}
