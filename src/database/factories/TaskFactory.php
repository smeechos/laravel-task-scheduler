<?php

use Faker\Generator as Faker;

$factory->define(\Smeechos\TaskScheduler\Models\Task::class, function (Faker $faker) {
    return [
        'command'   => $faker->text(15),
        'cron_id'   => \Smeechos\TaskScheduler\Models\Cron::inRandomOrder()->first()->id
    ];
});
