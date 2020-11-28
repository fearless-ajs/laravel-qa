<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;

       $voteCount =  Auth::user()->voteQuestion($question, $vote);

        if(request()->expectsJson()){
            return response()->json([
                'message'   => 'Thanks for the feedback',
                'voteCount' => $voteCount,
            ]);
        }
        return back();
    }
}
