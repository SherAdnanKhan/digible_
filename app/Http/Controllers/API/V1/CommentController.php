<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Services\Comments\CommentService;
use App\Http\Transformers\Comments\CommentTransformer;
use App\Http\Transformers\Comments\ReplyTransformer;
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

    /** @OA\Post(
     *     path="/api/users/comments/",
     *     description="Store Comment",
     *     summary="Store",
     *     operationId="StoreComment",
     *     security={{"bearerAuth":{}}},
     *     tags={"Comments"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="comment",
     *                     type="string",
     *                     example="I like this collection"
     *                 ),
     *                 @OA\Property(
     *                     property="collection_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Comment request created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Comment $comment
     * @return JsonResponse
     */

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $this->service->save($request->validated());
        return $this->success([], $this->transformer, trans('messages.comment_create_success'));
    }

    /** @OA\Get(
     *     path="/api/users/comments/{comment}",
     *     description="Get Comment",
     *     summary="Get by id",
     *     operationId="GetComment",
     *     security={{"bearerAuth":{}}},
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="comment",
     *         parameter="comment",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/Comment")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param Comment $comment
     * @return JsonResponse
     */

    public function show(Comment $comment): JsonResponse
    {
        $result = $this->service->get($comment);
        return $this->success($result, $this->transformer);
    }

    /** @OA\Delete(
     *     path="/api/users/comments/{comment}",
     *     description="Delete Comment",
     *     summary="Delete",
     *     operationId="deleteComment",
     *     security={{"bearerAuth":{}}},
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="comment",
     *         parameter="comment",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Comment Request deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Comment $comment
     * @return JsonResponse
     */

    public function destroy(Comment $comment): JsonResponse
    {
        $this->service->delete($comment);
        return $this->success([], null, trans('messages.comment_delete_success'));
    }

    /** @OA\Put(
     *     path="/api/users/comments/{comment}/",
     *     description="Update Comment",
     *     summary="Update",
     *     operationId="updateComment",
     *     security={{"bearerAuth":{}}},
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="comment",
     *         parameter="comment",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="comment",
     *                     type="string",
     *                     example="Great product i liked it"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Comment request updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Comment $comment
     * @return Json
     */

    public function update(Comment $comment, UpdateCommentRequest $request): JsonResponse
    {
        $comment->update($request->validated());
        return $this->success([], $this->transformer, trans('messages.comment_update_success'));
    }

    /** @OA\Post(
     *     path="/api/users/comments/{comment}/reply",
     *     description="Store reply",
     *     summary="Store Reply",
     *     operationId="StoreReply",
     *     security={{"bearerAuth":{}}},
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="comment",
     *         parameter="comment",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="comment",
     *                     type="string",
     *                     example="Thank you"
     *                 ),
     *                 @OA\Property(
     *                     property="collection_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Comment replied successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Comment $comment
     * @return JsonResponse
     */

    public function storeReply(StoreCommentRequest $request, Comment $comment): JsonResponse
    {
        $data = $request->validated();
        $data['comment_id'] = $comment->id;
        $this->service->save($data);
        return $this->success([], $this->transformer, trans('messages.comment_reply_create_success'));
    }
}
