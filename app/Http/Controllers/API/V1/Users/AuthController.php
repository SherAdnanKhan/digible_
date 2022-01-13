<?php

namespace App\Http\Controllers\API\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Users\AuthService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Users\UserLoginRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\ForgetUserRequest;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Users\TokenTransformer;
use App\Http\Requests\Users\ConfirmPasswordRequest;

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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="user@user.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="1234567"
     *                 ),
     *                 @OA\Property(
     *                     property="confirm_password",
     *                     type="string",
     *                     format="password",
     *                     example="1234567"
     *                 ),
     *                 @OA\Property(
     *                     property="timezone",
     *                     type="string",
     *                     example="Asia/Jerusalem"
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
     *                     example="admin@admin.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="12345678"
     *                 ),
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
     *                         property="id",
     *                         type="string",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="email",
     *                         example="user@email.com"
     *                     ),

     *                     @OA\Property(
     *                        property="role",
     *                        type="array",
     *                         @OA\Items(oneOf={
     *                              @OA\Property(
     *                                   property="name",
     *                                   type="string",
     *                                    example="user"
     *                              ),
     *                              @OA\Property(
     *                                   property="name",
     *                                   type="string",
     *                                    example="admin"
     *                              ),
     *                        }),),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="user"
     *                     ),
     *                     @OA\Property(
     *                         property="timezone",
     *                         type="string",
     *                         example="UTC"
     *                     ),
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
     *                         property="expires_at",
     *                         type="integer",
     *                         example="2022-12-29T06:49:55.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="verified",
     *                         type="bool",
     *                         example=true
     *                     ),
     *                     @OA\Property(
     *                        property="addresses",
     *                        type="object",
     *                        @OA\Property(
     *                            property="data",
     *                            type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                  property="id",
     *                                  type="string",
     *                                  example=1
     *                              ),
     *                              @OA\Property(
     *                                  property="address",
     *                                  type="string",
     *                                  example="0x49614661737efbfc6a102efaeefdc8e197f7cc0e"
     *                              ),
     *                          ),
     *                         @OA\Items(
     *                              @OA\Property(
     *                                  property="addresses",
     *                                  type="string",
     *                                  example=2
     *                              ),
     *                              @OA\Property(
     *                                  property="address",
     *                                 type="string",
     *                                 example="0x521db06bf657ed1d6c98553a70319a8ddbac75a3"
     *                              ),
     *                        ),),),
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
        return Redirect::to(config('app.frontend') . '/email/verify-success/'.$verified->accessToken);
    }

    public function forget(ForgetUserRequest $request)
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
        return redirect(Config::get('app.frontend').'/change-password/'.$token);
    }

    public function confirm(ConfirmPasswordRequest $request)
    {
        $result = $this->service->confirm($request->validated());
        if (!isset($result)) {
            return $this->failure('', trans('messages.forget_password_invalid_token_or_email'), Response::HTTP_BAD_REQUEST);
        }
        return $this->success([], null, trans('messages.forget_password_reset_success'));
    }

        /**
     * @OA\Post(
     *     path="/api/auth/reset-token",
     *     description="Reset token",
     *     summary="ResetToken",
     *     operationId="token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="user@user.com"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Verification Email Sent successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Verification Email Sent successfully"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 )
     *            )
     *         )
     *     )
     * )
     * @param ForgetUserRequest $request
     * @return JsonResponse
     */
    public function resetToken(ForgetUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if($user->email_verified_at) {
            return $this->success([], null, trans('messages.user_already_verifed'));
        }
        $this->service->resetToken($user);
        return $this->success([], null, trans('messages.token_reset_success'));
    }
}
