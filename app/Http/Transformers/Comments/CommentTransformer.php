<?php
namespace App\Http\Transformers\Comments;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\Comment;

class CommentTransformer extends BaseTransformer
{
    protected $defaultIncludes = ['status', 'parent', 'user'];

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'user_id' => $comment->parent_id,
            'parent_id' => $comment->parent_id,
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

    public function includeParent(Comment $comment)
    {
        $parent = Comment::find($comment->parent_id);
        if ($parent) {
            $parent = $parent->toArray();
            return $this->collection([$parent], new ReplyTransformer);
        }
        return;

    }

}
