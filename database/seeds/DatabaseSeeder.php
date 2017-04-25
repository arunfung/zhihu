<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Topic::class, 10)->create();
        $topic_ids = \App\Topic::all();
        factory(App\User::class, 20)->create()->each(function ($u) use ($topic_ids) {

            factory(App\Question::class, mt_rand(0, 10))->make()
                ->each(function ($question) use ($u, $topic_ids) {

                $q = $u->question()->save($question);
                $count = mt_rand(1, 4);
                $ids = [];
                for ($i = 0; $i < $count; $i++) {
                    array_push($ids, $topic_ids[mt_rand(1, 9)]->id);
                }
                $q->topics()->sync($ids);
            });

        });
        // $this->call(UsersTableSeeder::class);
    }
}
