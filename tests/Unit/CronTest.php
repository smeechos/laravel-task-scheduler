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
    use WithFaker;

    /**
     * Test that an instance of Cron can be created.
     *
     * Confirms that the returned object is an instance of type Cron, and also confirms that
     * the properties of the object our equal to our initial data.
     *
     * @return void
     * @test
     */
    public function it_can_create_cron()
    {
        $data = [
            'expression' => $this->faker->text(15),
            'description'   => $this->faker->text(35)
        ];

        $cron = Cron::create($data);
        $this->assertInstanceOf(Cron::class, $cron);
        $this->assertEquals($data['expression'], $cron->expression);
        $this->assertEquals($data['description'], $cron->description);

    }

    /**
     * Test that an instance of Cron can be retrieved.
     *
     * @return void
     * @test
     */
    public function it_can_get_cron()
    {
        $cron = factory(Cron::class)->create();
        $found = Cron::find($cron->id);

        $this->assertInstanceOf(Cron::class, $found);
        $this->assertEquals($found->expression, $cron->expression);
        $this->assertEquals($found->description, $cron->description);
    }

    /**
     * Test that an instance of Cron can be updated.
     *
     * Confirms that the result of the update is true, and also confirms that
     * the properties of the updated object our equal to our new data.
     *
     * @return void
     * @test
     */
    public function it_can_update_cron()
    {
        $cron = factory(Cron::class)->create();

        $data = [
            'expression' => $this->faker->text(15),
            'description'   => $this->faker->text(35)
        ];

        $result = $cron->update($data);

        $this->assertTrue($result);
        $this->assertEquals($data['expression'], $cron->expression);
        $this->assertEquals($data['description'], $cron->description);
    }

    /**
     * Test that an instance of Cron can be deleted.
     *
     * Confirms that the result of the delete is true, and also that the results of
     * searching the database for the Cron ID is empty.
     *
     * @return void
     * @test
     */
    public function it_can_delete_cron()
    {
        $cron = factory(Cron::class)->create();
        $id = $cron->id;
        $result = $cron->delete();

        $this->assertTrue($result);
        $this->assertEmpty(Cron::where('id', '=', $id)->first());
    }
}
