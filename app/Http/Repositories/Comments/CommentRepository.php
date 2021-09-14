<?php

namespace App\Http\Repositories\Comments;

use App\Models\Comment;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

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

    public function getAll()
    {
        return $this->comment->with('replies','user')
            ->get();
    }

    public function getById($id)
    {
        return $this->comment
            ->where('id', $id)->with('replies','user')
            ->get();
    }

    public function saveComment(array $data): void
    {
        $comment = new $this->comment;
        $comment->comment = $data['comment'];
        $comment->user()->associate($request->user());
        $collection = Collection::find($data['collection_id']);
        $collection->comments()->save($comment);

    }

    public function saveReply(array $data): void
    {
        $comment = new $this->comment;
        $reply->comment = $data['comment'];
        $reply->user()->associate(Auth::user()->id);
        $reply->parent_id = $data['comment_id'];
        $collection = Collection::find($data['collection_id']);
        $collection->comments()->save($reply);

    }

    public function delete($id)
    {
        $comment = $this->comment->find($id);
        $comment->delete();
        return $comment;
    }
}
