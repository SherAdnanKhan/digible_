<?php
namespace App\Http\Transformers\Collections;

use App\Models\Comment;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;

class ReplyTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user'
    ];

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'status' => $comment->status,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
        ];
    }

    public function includeUser(Comment $comment)
    {
        $user = $comment->user;
        return $this->item($user, new UserTransformer);
    }

}
