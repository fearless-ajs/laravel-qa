<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    //A relationship between the user and the questions
    public function user(){
        return $this->belongsTo(User::class);
    }
}
