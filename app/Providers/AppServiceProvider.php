<?php

namespace App\Providers;

use App\Models\Answer;
use App\Policies\AnswerPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

   protected $policies = [
       Answer::class => AnswerPolicy::class,
   ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
