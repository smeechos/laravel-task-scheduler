<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsControllerTests extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test the index method of SettingsController.
     *
     * Confirms that the route returns a 200 status, a view with a variable ($settings), that the $settings variable
     * has a key of 'logging', and the the specified strings appear on the page.
     *
     * @return void
     * @test
     */
    public function it_can_render_settings_page()
    {
        $response = $this->get('/task-scheduler/settings');

        $response->assertStatus(200);
        $response->assertViewHas( 'settings' );

        $settings = $response->original->getData()['settings'];

        $this->assertArrayHasKey('logging', $settings);
        $response->assertSeeInOrder(['Task Scheduler Settings', 'Error Logging']);
    }

    /**
     * Test the store method of SettingsController.
     *
     * Confirms the user is able to save the specified settings.
     *
     * @return void
     * @test
     */
    public function it_can_save_settings()
    {
        $data = [
            'logging'    => $this->faker->randomElement(['enabled', 'disabled'])
        ];

        $this->post('task-scheduler/settings', $data)
            ->assertStatus(302)
            ->assertRedirect(route('settings'))
            ->assertSessionHas('stsp-type', 'settings')
            ->assertSessionHas('stsp-status', 'success')
            ->assertSessionHas('stsp-message', 'Settings Successfully Saved!');
    }
}
