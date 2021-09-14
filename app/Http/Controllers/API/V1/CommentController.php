<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\ReplyStoreRequest;
use App\Http\Requests\Comments\StoreCommentRequest;

class CommentController extends Controller
{
    protected $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }
    public function store(StoreCommentRequest $request)
    {
        $data = $request->all();

        try {
            $this->service->storeComment($data);
        } catch (Execption $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success([], null, trans('messages.collection_create_success'));
    }

    public function replyStore(ReplyStoreRequest $request)
    {
        $data = $request->all();
        try {
            $this->service->replyStore($data);
        } catch (Execption $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success([], null, trans('messages.collection_create_success'));

    }
}
