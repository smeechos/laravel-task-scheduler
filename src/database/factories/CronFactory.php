<?php

//namespace Smeechos\TaskScheduler\Database\Factories;

use Faker\Generator as Faker;

$factory->define(\Smeechos\TaskScheduler\Models\Cron::class, function (Faker $faker) {
    $index = rand(0, 2);
    $expressions = [
        '* * * * *',
        '*/5 * * * *',
        '0 0 * * *'
    ];
    $descriptions = [
        'Every minute',
        'Every 5 minutes',
        'Everyday at 12:00 AM'
    ];

    return [
        'expression'    => $expressions[$index],
        'description'   => $descriptions[$index]
    ];
});
