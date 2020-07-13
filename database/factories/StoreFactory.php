<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Store;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Store::class, function (Faker $faker) {
    return [
        'id' => '6ff7a320-bd5d-11ea-b3de-0242ac130004',
        'secret_id' => '026f71f0-c2a5-11ea-b3de-0242ac130004',
        'name' => $faker->name,
        'domain' => $faker->url,
        'document' => $faker->cpf
    ];
});
