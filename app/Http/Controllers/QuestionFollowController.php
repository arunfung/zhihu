<?php

namespace App\Http\Controllers;

use App\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Auth;

/**
 * Class QuestionFollowController
 * @package App\Http\Controllers
 */
class QuestionFollowController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $question;

    /**
     * QuestionFollowController constructor.
     * @param QuestionRepository $question
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth')->except(['index']);
        $this->question = $question;
    }


    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follower(Request $request)
    {
        $followed = user('api')->followed($request->get('question'));
        if ($followed)
        {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function followThisQuestion(Request $request)
    {
        $question = $this->question->byId(request('question'));
        $followed = user('api')->followThis($question->id);
        if (count($followed['detached'])>0)
        {
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
