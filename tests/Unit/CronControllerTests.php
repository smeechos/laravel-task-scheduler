<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CronControllerTests extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testing index method of CronController.
     *
     * @return void
     * @test
     */
    public function test_index()
    {
        $response = $this->get('/task-scheduler/crons');
        $response->assertViewHas( 'crons' );
    }
}
