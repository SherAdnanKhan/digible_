<?php

namespace App\Http\Repositories\Comments;

use App\Models\Collection;
use App\Models\Comment;

class CommentRepository
{
    public function getPending()
    {
        return Comment::where(['status' => 'pending'])->with('commentable')->get();
    }

    public function getApproved()
    {
        return Comment::where(['status' => 'approved'])->with('commentable')->get();
    }

    public function get(Comment $comment)
    {
        $comments = Comment::where(['parent_id' => $comment->id, 'status' => 'approved'])->get();
        return $comments;
    }
    public function save(array $data): void
    {
        $comment = new Comment;
        $comment->comment = $data['comment'];
        $comment->status = $data['status'];
        $comment->parent_id = $data['comment_id'];
        $comment->user()->associate($data['user_id']);
        $collection = Collection::find($data['collection_id']);
        $collection->comments()->save($comment);
    }

    public function delete(Comment $comment)
    {
        Comment::where('parent_id', $comment->id)->delete();
        $comment->delete();
        return $comment;
    }
}
