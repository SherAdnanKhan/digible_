<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Models\Comment;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Comments\CommentService;
use App\Http\Transformers\Comments\ReplyTransformer;
use App\Http\Transformers\Comments\CommentTransformer;

class CommentBuyerController extends Controller
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

    /** @OA\Get(
     *     path="/api/collection/{collection}/comment'",
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
     *         name="collection",
     *         parameter="collection",
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

    public function index(Collection $collection): JsonResponse
    {
        $result = $this->service->getbyCollection($collection);
        return $this->success($result, $this->transformer);
    }

        /** @OA\Get(
     *     path="/api/comments/{comment}",
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
        $result = $this->service->getReplies($comment);
        return $this->success($result, $this->transformer);
    }
}
