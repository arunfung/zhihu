<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 04/04/2017
 * Time: 3:32 PM
 */

namespace App\Repositories;

use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @var Question
     */
    protected $question;
    /**
     * @var Topic
     */
    protected $topic;


    /**
     * QuestionRepository constructor.
     * @param Question $question
     * @param Topic $topic
     */
    public function __construct(Question $question, Topic $topic)
    {
        $this->question = $question;
        $this->topic = $topic;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return $this->question->where('id',$id)->with(['topics','answers'])->first();
    }



    public function create(array $attributes)
    {
        return $this->question->create($attributes);
    }

    /**
     * @return Question
     */
    public function byId($id)
    {
        return $this->question->find($id);
    }

    public function getQuestionsFeed()
    {
        return $this->question->published()->latest('updated_at')->with('user')->get();
    }

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic){
            if (is_numeric($topic)){
                $this->topic->find($topic)->increment('questions_count');
                return (int) $topic;
            }
            $newTopic = $this->topic->create([
                'name' => $topic,
                'topic_picture' => 'images/topics/topic_default.jpg',
                'questions_count' => 1
            ]);
            return $newTopic->id;
        })->toArray();
    }
}