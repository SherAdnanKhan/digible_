<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Services\Comments\CommentService;
use App\Http\Transformers\Comments\ReplyTransformer;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $this->service->save($request->validated());
        return $this->success([], $this->transformer, trans('messages.comment_create_success'));
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
        return $this->success($result, $this->transformer);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->service->delete($comment);
        return $this->success([], null, trans('messages.comment_delete_success'));
    }

    public function update(Comment $comment, UpdateCommentRequest $request): JsonResponse
    {
        $comment->update($request->validated());
        return $this->success([], $this->transformer, trans('messages.comment_updated_success'));
    }

    public function storeReply(StoreCommentRequest $request, Comment $comment): JsonResponse
    {
        $data = $request->validated();
        $data['comment_id'] = $comment->id;
        $this->service->save($data);
        return $this->success([], $this->transformer, trans('messages.comment_reply_create_success'));
    }
}
