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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
$factory->defineAs(App\Environment::class, 'parent', function (Faker\Generator $faker) {
	return [
		'name' => $faker->randomAscii,
		'parent_id' => null
	];
});
$factory->defineAs(App\Environment::class, 'child', function (Faker\Generator $faker) {
	return [
		'name' => $faker->randomAscii,
		'parent_id' => function() {
			return factory(App\Environment::class, 'parent')->create()->id;
		}
	];
});
