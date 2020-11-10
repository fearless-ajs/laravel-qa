<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(10);
        return view('questions.index', compact('questions'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $questions = new Question();
        return view('questions.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));

        session()->flash('success', 'Your question has been submitted');
        return redirect()->route('questions.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Contrxacts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Question $question)
    {
        //increment the number of views
        $question->increment('views');

        return view('questions.show', compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));
        session()->flash('success', 'Your question has been updated');
        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        $question->delete();
        session()->flash('success', 'Your question has been deleted');
        return redirect()->route('questions.index');

    }
}
