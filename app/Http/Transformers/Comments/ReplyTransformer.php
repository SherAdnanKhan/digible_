<?php
namespace App\Http\Transformers\Comments;

use App\Models\Comment;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class ReplyTransformer extends BaseTransformer
{
    protected $defaultIncludes = ['status'];
    protected $availableIncludes = ['user'];

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

    public function includeStatus(Comment $comment)
    {
        $item = [
            'id' => $comment->id,
            'name' => data_get(Comment::statuses(), $comment->status),
        ];

        return $this->item($item, new ConstantTransformer);
    }
}
