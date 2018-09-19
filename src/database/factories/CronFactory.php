<?php

use Faker\Generator as Faker;

$factory->define(\Smeechos\TaskScheduler\Models\Cron::class, function (Faker $faker) {
    return [
        'expression'    => $faker->text(15),
        'description'   => $faker->text(35)
    ];
});
