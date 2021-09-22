<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ConfirmPasswordRequest;
use App\Http\Requests\Users\ForgetPasswordRequest;
use App\Http\Requests\Users\UserLoginRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Services\Users\AuthService;
use App\Http\Transformers\Users\TokenTransformer;
use App\Http\Transformers\Users\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $service;

    /**
     * @var UserTransformer
     */
    private $transformer;

    public function __construct(
        AuthService $service,
        UserTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     description="Register",
     *     summary="Register",
     *     operationId="register",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         @OA\Schema(type="string"),
     *         in="query",
     *         allowReserved=true,
     *         required=false,
     *         name="ic",
     *         parameter="ic",
     *         example="91ec1a37-ce28-4f73-bb9c-06460f8f801d"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     example="Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="johndoe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="johndoe@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="I@86eik#"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="1234567890"
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
     *                     property="dob",
     *                     type="date",
     *                     example="1997-03-04"
     *                 ),
     *                 @OA\Property(
     *                     property="country_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="hear_about_us_platform_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User created successfully"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 )
     *            )
     *         )
     *     )
     * )
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function register(UserStoreRequest $request): JsonResponse
    {
        $this->service->register($request->validated());

        return $this->success([], null, trans('messages.user_create_success'));
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     description="Login",
     *     summary="Login",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="johndoe@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="I@86eik#"
     *                 ),
     *                 @OA\Property(
     *                     property="remember_me",
     *                     type="boolean",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User logged in successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User logged in successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwMTU1NzYzNywiZXhwIjoxNjAxNjQ0MDM3LCJuYmYiOjE2MDE1NTc2MzcsImp0aSI6IkRTMnNhRFJkVDVyVmhaUDUiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.IJuX7ncjt6FBx8QU1md3ELGrB-5cPfKiZ6iSA5tAouQ"
     *                     ),
     *                     @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         example="Bearer"
     *                     ),
     *                     @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         example=86400
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserLoginRequest $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (!$token = $this->service->login($request->validated())) {
            throw new ErrorException('exception.invalid_credentials', [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->success($token, new TokenTransformer, trans('messages.user_login_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     description="Logout",
     *     summary="Logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="User logged out successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User logged out successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request);
        return $this->success([], null, trans('messages.user_logout_success'));
    }

    /**
     * @param $token
     * @return RedirectResponse
     */
    public function userActivate($token): RedirectResponse
    {
        $verified = $this->service->userActivate($token);
        if (!$verified) {
            return Redirect::to(config('app.frontend') . '/email/verify-failure');
        }
        return Redirect::to(config('app.frontend') . '/email/verify-success');
    }

    public function forget(ForgetPasswordRequest $request)
    {
        $this->service->forget($request->validated());
        return $this->success([], null, trans('messages.forget_password_success'));
    }

    public function reset(string $token)
    {
        $user = $this->service->validateTokenAndGetUser($token);
        if (!isset($user)) {
            return $this->failure('', trans('messages.forget_password_invalid_token'), Response::HTTP_BAD_REQUEST);
        }
        return $this->success([], null, trans('messages.forget_password_token_validate_success'));
    }

    public function confirm(ConfirmPasswordRequest $request)
    {
        $result = $this->service->confirm($request->validated());
        if (!isset($result)) {
            return $this->failure('', trans('messages.forget_password_invalid_token_or_email'), Response::HTTP_BAD_REQUEST);
        }
        return $this->success([], null, trans('messages.forget_password_reset_success'));
    }
}
