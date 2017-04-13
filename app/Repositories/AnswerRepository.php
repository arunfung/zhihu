<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 04/04/2017
 * Time: 11:01 PM
 */

namespace App\Repositories;

use App\Answer;

/**
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository
{
    /**
     * @var Answer
     */
    protected $answer;

    /**
     * AnswerRepository constructor.
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @param array $attributes
     * @return
     */
    public function create(array $attributes)
    {
        return $this->answer->create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return $this->answer->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAnswerCommentsById($id)
    {
        $answer = $this->answer->with('comments','comments.user')->where('id',$id)->first();
        return $answer->comments;
    }
}