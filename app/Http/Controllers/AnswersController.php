<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, Request $request)
    {
//        $request->validate([
//           'body' => 'required'
//        ]);

        $question->answers()->create( $request->validate([
            'body' => 'required'
        ]) + ['user_id' => Auth::user()->id]);

        session()->flash('success', 'Your answer has been submitted');
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers._edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Question $question, Request $request, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        if ($request->expectsJson()){ //This is coming from a form submit
            return response()->json([
               'message' => 'Your answer has been updated',
               'body_html' => $answer->body_html
            ]);
        }

        session()->flash('success', 'Your answer has been updated');
        return redirect()->route('questions.show', $question->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question, Answer $answer)
    {
         $this->authorize('delete', $answer);

         $answer->delete();

        if (request()->expectsJson())
        { //Notice this is not coming from a form submit
            return response()->json([
                'message' => 'Your answer has been deleted',
            ]);
        }

         session()->flash('success', 'Your answer has been deleted');
         return redirect()->back();
    }
}
