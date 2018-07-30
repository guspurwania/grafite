<?php
/*
|--------------------------------------------------------------------------
| Customer Factory
|--------------------------------------------------------------------------
*/

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
    return [
        'id' => '1',
		'name' => '1',
    ];
});
