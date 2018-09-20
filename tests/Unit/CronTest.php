<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Smeechos\TaskScheduler\Models\Cron;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CronTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that a model can be created.
     *
     * @return void
     * @test
     */
    public function can_create_cron()
    {
        $cron = factory(Cron::class, 1)->make()->first();
        $this->assertInstanceOf(Cron::class, $cron);
    }

    /**
     * Test that a model can be updated.
     *
     * @return void
     * @test
     */
    public function can_update_cron()
    {
        $cron = factory(Cron::class, 1)->make()->first();
        $expression = $cron->expression;
        $cron->expression = 'updated expression';
        $cron->save();
        $this->assertNotEquals($expression, $cron->expression);
    }
}
