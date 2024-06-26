<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\CommissionModel;
use App\Models\SalesCommission;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \Faker\Provider\Uuid;
use App\Enums\UserRole;
use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {


    $email = $faker->unique()->email;

    if(User::where('email',$email)->first()){
        $email = Str::random(5).$email;
    }

    return [
        'name' => $faker->name,
        'email' => $email,
        'password' => 'password', 
        'remember_token' => Str::random(10),
    ];
});

