<?php
namespace App\Http\Services\Comments;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Comments\CommentRepository;
use App\Http\Services\BaseService;
use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Commentservice extends BaseService
{
    protected $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPending()
    {
        Log::info(__METHOD__ . " -- Comment data all fetched: ");
        return $this->repository->getPending();
    }

    public function get(Comment $comment)
    {
        try {

            Log::info(__METHOD__ . " -- Comment data all fetched: ");
            return $this->repository->get($comment);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function save(array $data)
    {
        try {
            $newData['comment'] = $data['comment'];
            $newData['user_id'] = Auth::user()->id;
            $newData['status'] = 'pending';
            $newData['comment_id'] = null;

            if (isset($data['comment_id'])) {
                $commentExist = Comment::where(['id'=> $data['comment_id'] , 'status' => 'approved']);
                if ($commentExist) {
                    $newData['comment_id'] = $data['comment_id'];
                } else {
                    return false;
                }
            }
            $newData['collection_id'] = $data['collection_id'];
            Log::info(__METHOD__ . " -- New comment request info: ", $newData);
            $this->repository->save($newData);
            return true;

        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function delete(Comment $comment)
    {
        $comment = $this->repository->delete($comment);
    }

}
