<?php
namespace App\Http\Services\Comments;

use App\Http\Repositories\Comments\CommentRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Commentservice extends BaseService
{
    protected $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Comment data all fetched: ");
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        Log::info(__METHOD__ . " -- Comment data fetched ");
        return $this->repository->getById($id);
    }

    public function storeComment(array $data): void
    {
        Log::info(__METHOD__ . " -- New Comment request info: ", $data);
        $this->repository->saveComment($data);
    }

     public function replyStore(array $data): void
    {
        Log::info(__METHOD__ . " -- New Comment reply request info: ", $data);
        $this->repository->saveReply($data);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            Log::info(__METHOD__ . " -- Comment data deleted ");
            $Comment = $this->repository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Comment data');
        }

        DB::commit();
        return $Comment;
    }
}
