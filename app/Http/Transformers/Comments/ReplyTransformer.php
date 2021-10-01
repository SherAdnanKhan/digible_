<?php
namespace App\Http\Transformers\Comments;

use App\Models\Comment;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class ReplyTransformer extends BaseTransformer
{

    public function transform($comment)
    {
        return [
            'id' => $comment['id'],
            'comment' => $comment['comment'],
            'user_id' => $comment['user_id'],
            'parent_id' => $comment['parent_id'],
            'status' => $comment['status'],
            'created_at' => $comment['created_at'],
            'updated_at' => $comment['updated_at'],
        ];
    }
}
