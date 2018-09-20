<?php

namespace Smeechos\TaskScheduler\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Smeechos\TaskScheduler\Models\TaskSchedulerSettings;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that the logging settings can be changed.
     *
     * @return void
     * @test
     */
    public function can_update_logging_setting()
    {
        $logging = TaskSchedulerSettings::where('setting', '=', 'logging')->first();
        $status = $logging->status;
        $logging->status = 'enabled';
        $logging->save();
        $this->assertNotEquals($status, $logging->status);
    }
}
