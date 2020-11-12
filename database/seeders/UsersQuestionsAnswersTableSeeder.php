<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();


        User::factory()->count(10)->create()->each(function ($u){
            $u->questions()
                ->saveMany(
                    Question::factory()->count(10)->make()
                )
                ->each(function ($q){
                    $q->answers()
                        ->saveMany(
                            Answer::factory()->count(10)->make()
                        );
                });
        });
    }
}
