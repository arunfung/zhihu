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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
$dir = public_path('uploads/avatars');
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
//        'avatar' => $faker->image($dir, 300, 300, 'nature', true, false),
        'avatar' => '/images/avatars/default.png',
        'confirmation_token' => str_random(40),
        'api_token' => str_random(60),
        'settings' => ['city'=>'']
    ];
});

$factory->define(App\Topic::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'bio' => $faker->paragraph,
        'topic_picture' => $faker->imageUrl(),
        'questions_count' => 1,
    ];
});

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    $html_content = join("\n\n", $faker->paragraphs(mt_rand(7, 20)));
    return [
        'title' => $faker->sentence(mt_rand(5, 10)),
        'body' => $html_content,
//        'description' => $faker->sentence(mt_rand(5, 15)),
        /*'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },*/
    ];
});
