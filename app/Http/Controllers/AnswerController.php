<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

/**
 * Class AnswerController
 * @package App\Http\Controllers
 */
class AnswerController extends Controller
{
    /**
     * @var AnswerRepository
     */
    protected $answerRepository;

    /**
     * AnswerController constructor.
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @param StoreAnswerRequest $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answerRepository->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ]);
        $answer->question->increment('answers_count');
        return back();
    }
}
