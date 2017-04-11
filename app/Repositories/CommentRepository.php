<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 11/04/2017
 * Time: 11:22 AM
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    protected $comment;

    /**
     * CommentRepository constructor.
     * @param $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function create(array $attributes)
    {
        return $this->comment->create($attributes);
    }
}