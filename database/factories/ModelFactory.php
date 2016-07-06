<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Url::class, function (Faker\Generator $faker) {
    return [
        'url' => $faker->url,
        'shorten' => base_convert(rand(10000,99999), 10, 36),
    ];
});
