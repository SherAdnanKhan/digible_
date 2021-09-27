<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StatusRequest;
use App\Http\Services\Comments\CommentService;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentAdminController extends Controller
{
    protected $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getPending();
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

    public function approved()
    {
        return $this->service->getApproved();
    }

}
