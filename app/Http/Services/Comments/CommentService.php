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
    protected $service;

    public function __construct(CommentRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getPending()
    {
        Log::info(__METHOD__ . " -- Comment data all fetched: ");
        $result = $this->repository->getPending();
        return $this->service->paginate($result);
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " --Approved Comment data all fetched: ");
        $result = $this->repository->getApproved();
        return $this->service->paginate($result);
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

    public function getReplies(Comment $comment)
    {
        try {
            Log::info(__METHOD__ . " -- Comment data all fetched: ");
            return $this->repository->getReplies($comment);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function getbyModel($model)
    {
        try {
            Log::info(__METHOD__ . " -- Comment data all fetched: ");
            return $this->repository->getbyModel($model);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function save(array $data)
    {
        try {
            $data['user_id'] = Auth::user()->id;
            $data['status'] = Comment::STATUS_PENDING;
            $data['comment_id'] = null;

            if (isset($data['id'])) {
                if (isset($data['collection_item_id'])) {
                    $commentExist = Comment::where(['id' => $data['id'], 'status' => Comment::STATUS_APPROVED,'commentable_type' => 'App\Models\CollectionItem'])->first();
                } else {
                    $commentExist = Comment::where(['id' => $data['id'], 'status' => Comment::STATUS_APPROVED])->first();
                }
                if ($commentExist) {
                    $data['comment_id'] = $data['id'];
                } else {
                    return false;
                }
            }
            Log::info(__METHOD__ . " -- New comment request info: ", $data);
            $this->repository->save($data);
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
