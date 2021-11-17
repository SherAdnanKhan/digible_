<?php

namespace App\Http\Repositories\Comments;

use App\Models\Collection;
use App\Models\Comment;

class CommentRepository
{
    public function getPending()
    {
        return Comment::where(['status' => 'pending'])->with('user')->get();
    }

    public function getApproved()
    {
        return Comment::where(['status' => 'approved'])->with('user')->get();
    }

    public function get(Comment $comment)
    {
        $comments = Comment::where(['id' => $comment->id, 'status' => 'approved'])->with('replies')->get();
        return $comments;
    }

    public function getReplies(Comment $comment)
    {
        $comments = Comment::where(['status' => 'approved', 'parent_id' => $comment->id])->get();
        return $comments;
    }

    public function getbyCollection(Collection $collection)
    {
        $comments = $collection->comments()->get();
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
