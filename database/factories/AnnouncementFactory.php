<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Announcement;
use Faker\Generator as Faker;

$factory->define(Announcement::class, function (Faker $faker) {
    return [
        'title' => 'Test',
        'content' => '<p>Test</p>',
        'start_date' => now()->__toString(),
        'end_date' => now()->__toString(),
        'active' => Announcement::STATUS_ACTIVE,
    ];
});
