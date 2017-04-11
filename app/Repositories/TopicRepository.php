<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 11/04/2017
 * Time: 11:57 AM
 */

namespace App\Repositories;


use App\Topic;
use Illuminate\Http\Request;

class TopicRepository
{
    protected $topic;

    /**
     * TopicRepository constructor.
     * @param $topic
     */
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function getTopicsForTagging(Request $request)
    {
        return $this->topic->select(['id','name'])
            ->where('name','like','%'.$request->query('q').'%')
            ->get();
    }
}