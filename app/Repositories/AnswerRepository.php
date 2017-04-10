<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 04/04/2017
 * Time: 11:01 PM
 */

namespace App\Repositories;

use App\Answer;

class AnswerRepository
{
    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function create(array $attributes)
    {
        return $this->answer->create($attributes);
    }

    public function byId($id)
    {
        return $this->answer->find($id);
    }
}