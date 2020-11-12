<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUrlAttribute(){
//        return route('questions.show', $this->id);
        return '#';
    }

    //User Relationship model with the questions
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute(){
        $email = $this->email;
        $size  = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" .  $size;
    }

    public function favorites(){
        //To implemets many to may relationship
        $this->belongsToMany(Question::class, 'favorites'/** Not neccessary since we are following cnvention, 'user_id', 'question_id'**/)->withTimestamps(); //specify with a table

    }

    public function voteQuestions(){
        /*
         * use the singular form of the table name as the aurgument,
         * laravel will detect the the votable_id and votable_type
         * dynamically
         */
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers(){
        /*
         * use the singular form of the table name as the aurgument,
         * laravel will detect the the votable_id and votable_type
         * dynamically
         */
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
       $voteQuestions =  $this->voteQuestions();
       if ($voteQuestions->where('votable_id', $question->id)->exists()){
          $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
       }else{
           $voteQuestions->attach($question, ['vote' => $vote]);
       }
       $question->load('votes');
       $downVotes = (int) $question->downVotes()->sum('vote');
       $upVotes = (int) $question->upVotes()->sum('vote');

       $question->votes_count = $upVotes + $downVotes;
       $question->save();

    }


}
