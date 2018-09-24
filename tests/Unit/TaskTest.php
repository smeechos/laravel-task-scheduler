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
    use WithFaker;

    /**
     * Test that an instance of Task can be created.
     *
     * Confirms that the returned object is an instance of type Task, and also confirms that
     * the properties of the object our equal to our initial data.
     *
     * @return void
     * @test
     */
    public function it_can_create_task()
    {
        $data = [
            'command'   => $this->faker->text(15),
            'cron_id'   => factory(\Smeechos\TaskScheduler\Models\Cron::class)->create()->id
        ];

        $task = Task::create($data);
        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($data['command'], $task->command);
        $this->assertEquals($data['cron_id'], $task->cron_id);

    }

    /**
     * Test that an instance of Task can be retrieved.
     *
     * Confirms that the found instance is of the type Task, and that its properties
     * match that of the instance that was created.
     *
     * @return void
     * @test
     */
    public function it_can_get_task()
    {
        $task = factory(Task::class)->create();
        $found = Task::find($task->id);

        $this->assertInstanceOf(Task::class, $found);
        $this->assertEquals($found->command, $task->command);
        $this->assertEquals($found->cron_id, $task->cron_id);
    }

    /**
     * Test that an instance of Task can be updated.
     *
     * Confirms that the result of the update is true, and also confirms that
     * the properties of the updated object our equal to our new data.
     *
     * @return void
     * @test
     */
    public function it_can_update_task()
    {
        $task = factory(Task::class)->create();

        $data = [
            'command'   => $this->faker->text(15),
            'cron_id'   => factory(\Smeechos\TaskScheduler\Models\Cron::class)->create()->id
        ];

        $result = $task->update($data);

        $this->assertTrue($result);
        $this->assertEquals($data['command'], $task->command);
        $this->assertEquals($data['cron_id'], $task->cron_id);
    }

    /**
     * Test that an instance of Task can be deleted.
     *
     * Confirms that the result of the delete is true, and also that the results of
     * searching the database for the Cron ID is empty.
     *
     * @return void
     * @test
     */
    public function it_can_delete_cron()
    {
        $task = factory(Task::class)->create();
        $id = $task->id;
        $result = $task->delete();

        $this->assertTrue($result);
        $this->assertEmpty(Task::where('id', '=', $id)->first());
    }
}
