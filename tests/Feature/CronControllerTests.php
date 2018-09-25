<?php

namespace Smeechos\TaskScheduler\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Smeechos\TaskScheduler\Models\Cron;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CronControllerTests extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Testing index method of CronController.
     *
     * Confirms that the route returns status 200, a view with a variable ($crons) that is
     * an instance of Illuminate\Database\Eloquent\Collection, and that certain strings are seen.
     *
     * @return void
     * @test
     */
    public function it_can_show_cron_page()
    {
        $response = $this->get('/task-scheduler/crons');

        $response->assertStatus(200);
        $response->assertViewHas( 'crons' );

        $crons = $response->original->getData()['crons'];

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $crons);
        $response->assertSeeInOrder(['Add New Cron', 'Cron Expression', 'Description of Expression',
            'All Cron Schedules', 'Expression', 'Description', 'Linked Tasks', 'Actions']);
    }

    /**
     * Testing store method of CronController.
     *
     * Posts to the URI, asserts that the status is a 302 and is redirected to
     * the route 'crons', with the specified session variables (flash message).
     *
     * @return void
     * @test
     */
    public function it_can_create_cron()
    {
        $data = [
            'expression'    => $this->faker->text(15),
            'description'   => $this->faker->text(35),
            '_token'        => csrf_token()
        ];

        $this->post('task-scheduler/crons/add', $data)
            ->assertStatus(302)
            ->assertRedirect(route('crons'))
            ->assertSessionHas('stsp-status', 'success')
            ->assertSessionHas('stsp-message', 'Cron Expression Successfully Added!');
    }

    /**
     * Testing edit method of CronController.
     *
     * @return void
     * @test
     */
    public function it_can_render_edit_screen()
    {
        $cron = factory(Cron::class)->create();

        $response = $this->get('task-scheduler/crons/edit/' . $cron->id);

        $response->assertStatus(200);
        $response->assertViewHas( 'cron' );

        $cron = $response->original->getData()['cron'];

        $this->assertInstanceOf('Smeechos\TaskScheduler\Models\Cron', $cron);
        $response->assertSeeInOrder(['Edit Cron', 'Cron Expression', 'Description of Expression']);
    }

    /**
     * Testing update method of CronController.
     *
     * Posts to the URI, asserts that the status is a 302 and is redirected to
     * the route 'crons', with the specified session variables (flash message).
     *
     * @return void
     * @test
     */
    public function it_can_update_cron()
    {
        $cron = factory(Cron::class)->create();

        $data = [
            'expression'    => $this->faker->text(15),
            'description'   => $this->faker->text(35),
            '_token'        => csrf_token()
        ];

        $this->post('task-scheduler/crons/edit/' . $cron->id, $data)
            ->assertStatus(302)
            ->assertRedirect(route('crons'))
            ->assertSessionHas('stsp-status', 'success')
            ->assertSessionHas('stsp-message', 'Cron Expression Successfully Updated!');
    }

    /**
     * Testing show method of CronController.
     *
     * @return void
     * @test
     */
    public function it_can_render_show_screen()
    {
        $cron = factory(Cron::class)->create();

        $response = $this->get('task-scheduler/crons/delete/' . $cron->id);

        $response->assertStatus(200);
        $response->assertViewHas( 'cron' );

        $cron = $response->original->getData()['cron'];

        $this->assertInstanceOf('Smeechos\TaskScheduler\Models\Cron', $cron);
        $response->assertSeeInOrder(['Delete Cron', 'Cron Expression', 'Description of Expression']);
    }

    /**
     * Testing destroy method of CronController.
     *
     * @return void
     * @test
     */
    public function it_can_delete_cron()
    {
        $cron = factory(Cron::class)->create();

        $data = [
            '_token'        => csrf_token()
        ];

        $this->post('task-scheduler/crons/delete/' . $cron->id, $data)
            ->assertStatus(302)
            ->assertRedirect(route('crons'))
            ->assertSessionHas('stsp-status', 'success')
            ->assertSessionHas('stsp-message', 'Cron Expression Successfully Deleted!');

    }
}
