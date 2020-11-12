<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           UsersQuestionsAnswersTableSeeder::class,
           FavoritesTableSeeder::class,
           VotablesTableSeeder::class,
        ]);

//        User::factory()->count(10)->create();
//        Question::factory()->count(40)->create();
//        \App\Models\User::factory(10)->create();
    }
}
