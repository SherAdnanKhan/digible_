<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatRequest;
use App\Http\Requests\Chat\UpdateChatRequest;
use App\Http\Services\Chats\ChatService;
use App\Http\Transformers\Chats\ChatTransformer;
use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;

class ChatMessageController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(ChatService $service, ChatTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Post(
     *     path="/api/chats/",
     *     description="Store Chat Message",
     *     summary="Store",
     *     operationId="StoreChatMessage",
     *     security={{"bearerAuth":{}}},
     *     tags={"ChatMessages"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="I like this collection"
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
     *                     example="Message created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param ChatMessage $chatMessage
     * @return JsonResponse
     */

    public function store(StoreChatRequest $request): JsonResponse
    {
        $this->service->save($request->validated());
        return $this->success([], $this->transformer, trans('messages.chat_create_success'));
    }

    /** @OA\Delete(
     *     path="/api/chats/{chatMessage}",
     *     description="Delete Message",
     *     summary="Delete",
     *     operationId="deleteMessage",
     *     security={{"bearerAuth":{}}},
     *     tags={"ChatMessages"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="chatMessage",
     *         parameter="chatMessage",
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
     *                     example="Message deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param ChatMessage $chatMessage
     * @return JsonResponse
     */

    public function destroy(ChatMessage $chatMessage): JsonResponse
    {dd($chatMessage->sender_id);
        if ($chatMessage && (auth()->user()->hasRole('admin') ||
            auth()->user()->id == $chatMessage->sender_id)) {
            
            $this->service->delete($chatMessage);
            return $this->success([], null, trans('messages.collection_delete_success'));
        }
        return $this->failure('', trans('messages.unauthorize_user_delete'));
    }

    /** @OA\Put(
     *     path="/api/chats/{chatMessage}/",
     *     description="Update Message",
     *     summary="Update",
     *     operationId="updateMessage",
     *     security={{"bearerAuth":{}}},
     *     tags={"ChatMessages"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="chatMessage",
     *         parameter="chatMessage",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
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
     *                     example="Message updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param ChatMessage $chatMessage
     * @return Json
     */

    public function update(ChatMessage $chatMessage, UpdateChatRequest $request): JsonResponse
    {
        $chatMessage->update($request->validated());
        return $this->success([], $this->transformer, trans('messages.chat_update_success'));
    }

    /** @OA\Post(
     *     path="/api/chats/{chatMessage}/reply",
     *     description="Store reply",
     *     summary="Store Reply",
     *     operationId="StoreReply",
     *     security={{"bearerAuth":{}}},
     *     tags={"ChatMessages"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="chatMessage",
     *         parameter="chatMessage",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Thank you"
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
     *                     example="Message replied successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param ChatMessage $chatMessage
     * @return JsonResponse
     */

    public function storeReply(StoreChatRequest $request, ChatMessage $chatMessage): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $chatMessage->id;
        $this->service->save($data);
        return $this->success([], $this->transformer, trans('messages.chat_reply_create_success'));
    }
}
