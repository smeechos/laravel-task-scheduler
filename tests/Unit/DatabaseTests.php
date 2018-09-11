<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function has_logging_setting()
    {
        $this->assertDatabaseHas('task_scheduler_settings', [
            'setting' => 'logging'
        ]);
    }
}
