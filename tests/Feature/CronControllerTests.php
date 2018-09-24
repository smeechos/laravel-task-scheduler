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
     * Tests that the route returns a view with a variable, $crons, that is
     * an instance of Illuminate\Database\Eloquent\Collection.
     *
     * @return void
     * @test
     */
    public function test_index()
    {
        $response = $this->get('/task-scheduler/crons');

        $response->assertViewHas( 'crons' );

        $crons = $response->original->getData()['crons'];

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $crons);
    }
}
