<?php

namespace App\Http\Controllers\API\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdatePasswordRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Services\Users\UserService;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @var UserTransformer
     */
    private $transformer;

    public function __construct(
        UserService $service,
        UserTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     description="Get User",
     *     summary="Get User",
     *     operationId="getUser",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
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
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/User")
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = $this->service->getAll();

        return $this->success($user, $this->transformer);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user}/update-password/",
     *     description="Update Password",
     *     summary="Update Password",
     *     operationId="updatePassword",
     *     security={{"bearerAuth":{}}},
     *     tags={"Update Password"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="abc12345"
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     type="string",
     *                     example="abcd123?1#"
     *                 ),
     *                 @OA\Property(
     *                     property="confirm_password",
     *                     type="string",
     *                     example="abcd123?1#"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Password is changed",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Password is changed"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UpdatePasswordRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request, User $user): JsonResponse
    {
        $response = $this->service->updatePassword($user, $request->validated());

        if ($response) {
            return $this->success('', null, trans('messages.update_user_password'));
        }
        Log::error(__METHOD__ . " -- user: " . $user->email . " -- User entered the wrong old password to change password");
        return $this->failure('', trans('passwords.user_password_error'), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user}",
     *     description="Update Account",
     *     summary="Update Account",
     *     operationId="updateAccount",
     *     security={{"bearerAuth":{}}},
     *     tags={"Update Account"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="johndoe"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="+3334562555"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     example="130 Botley Road"
     *                 ),
     *                 @OA\Property(
     *                     property="address2",
     *                     type="string",
     *                     example="Shore Street"
     *                 ),
     *                 @OA\Property(
     *                     property="address3",
     *                     type="string",
     *                     example="Pier Road"
     *                 ),
     *                 @OA\Property(
     *                     property="county",
     *                     type="string",
     *                     example="Bristol"
     *                 ),
     *                 @OA\Property(
     *                     property="postcode",
     *                     type="string",
     *                     example="BS"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     example="Bristol"
     *                 ),
     *                 @OA\Property(
     *                     property="profile_image",
     *                     type="string",
     *                     format="base64img",
     *                     example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAACWAAAA..."
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Information is updated",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Information is updated"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                    allOf={
     *                         @OA\Schema(ref="#/components/schemas/User")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $this->service->updateUser($user, $request->validated());

        return $this->success($user, $this->transformer, trans('messages.update_user_account'));
    }
}
