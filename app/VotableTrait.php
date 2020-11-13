<?php


namespace App;


use App\Models\User;

trait VotableTrait
{
    public function votes(){
        /*
         * use the singular form of the table name as the aurgument,
         * laravel will detect the the votable_id and votable_type
         * dynamically
         */
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVotes(){
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes(){
        return $this->votes()->wherePivot('vote', -1);
    }
}
