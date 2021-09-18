<?php

namespace App\Http\Repositories\Comments;

use App\Models\Collection;
use App\Models\Comment;

class CommentRepository
{
    protected $comment;
    /**
     * @param array $
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;

    }

    public function getPending()
    {
        return $this->comment->where(['status' => 'pending'])->get();
    }

    public function get(Comment $comment)
    {
        $comments = Comment::where(['parent_id' => $comment->id , 'status' => 'approved'])->get();
        return $comments;
    }
    public function save(array $data): void
    {
        $comment = new $this->comment;
        $comment->comment = $data['comment'];
        $comment->status = $data['status'];
        $comment->parent_id = $data['comment_id'];
        $comment->user()->associate($data['user_id']);
        $collection = Collection::find($data['collection_id']);
        $collection->comments()->save($comment);
    }

    public function delete(Comment $comment)
    {
        $this->comment->where('parent_id', $comment->id)->delete();
        $comment->delete();
        return $comment;
    }
}
