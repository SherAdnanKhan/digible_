<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StatusRequest;
use App\Http\Services\Comments\CommentService;
use App\Http\Transformers\Comments\CommentTransformer;

class CommentAdminController extends Controller
{
    protected $service;
    protected $transformer;
    protected $replyTransformer;

    public function __construct(CommentService $service, CommentTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->service->getPending();
        return $this->success($result, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatusRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment->update($data);
        return $this->success([], null, trans('messages.comment_approved_success'));
    }

}
