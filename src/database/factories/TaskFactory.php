<?php

use Faker\Generator as Faker;

$factory->define(\Smeechos\TaskScheduler\Models\Task::class, function (Faker $faker) use ($factory) {
    return [
        'command'   => $faker->text(15),
        'cron_id'   => function () {
            return factory(\Smeechos\TaskScheduler\Models\Cron::class)->create()->id;
        }
    ];
});
