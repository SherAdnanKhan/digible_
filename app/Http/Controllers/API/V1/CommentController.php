<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Comment;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Comments\CommentService;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Http\Transformers\Collections\ReplyTransformer;

class CommentController extends Controller
{
    protected $service;
    protected $transformer;
    protected $replyTransformer;

    public function __construct(CommentService $service, CommentTransformer $transformer, ReplyTransformer $replyTransformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
        $this->replyTransformer = $replyTransformer;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->service->save($data);
        return $this->success($result, $this->transformer, trans('messages.comment_create_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $Collection
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment): JsonResponse
    {
        $result = $this->service->get($comment);
        return $this->success($result, $this->replyTransformer);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $result = $this->service->delete($comment);
        return $this->success([], null, trans('messages.comment_delete_success'));
    }

    public function update(Comment $comment, UpdateCommentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $comment->update($data);
        return $this->success([], $this->transformer, trans('messages.comment_updated_success'));
    }

    public function storeReply(StoreCommentRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $data['comment_id'] = $id;
        $result = $this->service->save($data);
        if ($result) {
            return $this->success([], $this->transformer, trans('messages.comment_reply_create_success'));
        }
        return $this->failure('', trans('messages.comment_not_exist'), Response::HTTP_BAD_REQUEST);
    }
}
