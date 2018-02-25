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

$factory->define(App\Models\Playlist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'owner_id' => $faker->userName,
        'playlist_url' => $faker->domainName,
        'owner_profile_url' => $faker->domainName,
        'playlist_thumbnail_url' => $faker->domainName
    ];
});

$factory->define(App\Models\Track::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->words(3, true),
        'artist' => $faker->name,
        'album' => $faker->words(3, true),
        'duration' => $faker->randomNumber,
        'spotify_track_id' => $faker->randomNumber,
        'spotify_url' => $faker->domainName,
        'spotify_preview_url' => $faker->domainName,
        'spotify_thumbnail_url' => $faker->domainName
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
    ];
});

$factory->define(App\Models\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'spotify_account_id' => $faker->userName
    ];
});