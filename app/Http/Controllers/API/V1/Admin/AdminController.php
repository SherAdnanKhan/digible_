<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Http\Services\Admins\AdminService;
use App\Http\Transformers\Admins\AdminTransformer;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * @var AuthService
     */
    private $service;

    /**
     * @var AdminTransformer
     */
    private $transformer;

    public function __construct(
        AdminService $service,
        AdminTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/admin/admins",
     *     description="Get admins",
     *     summary="Get all",
     *     operationId="getAdmins",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin"},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                      property="current_page",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/User")
     *                  ),
     *                  @OA\Property(
     *                         property="first_page_url",
     *                         type="string",
     *                         example="/?page=1"
     *                     ),
     *                     @OA\Property(
     *                         property="from",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="last_page",
     *                         type="integer",
     *                         example=3
     *                     ),
     *                     @OA\Property(
     *                         property="last_page_url",
     *                         type="string",
     *                         example="/?page=1"
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="array",
     *                         @OA\Items(
     *                              @OA\Property(
     *                              property="url",
     *                              type="string",
     *                              example=null
     *                              ),
     *                              @OA\Property(
     *                              property="label",
     *                              type="string",
     *                              example="&laquo; Previous"
     *                              ),
     *                              @OA\Property(
     *                              property="active",
     *                              type="boolean",
     *                              example=false
     *                              ),
     *                         ),
     *                         @OA\Items(
     *                              @OA\Property(
     *                              property="url",
     *                              type="string",
     *                              example="/?page=1"
     *                              ),
     *                              @OA\Property(
     *                              property="label",
     *                              type="string",
     *                              example="1"
     *                              ),
     *                              @OA\Property(
     *                              property="active",
     *                              type="boolean",
     *                              example=true
     *                              ),
     *                         ),
     *                         @OA\Items(
     *                              @OA\Property(
     *                              property="url",
     *                              type="string",
     *                              example=null
     *                              ),
     *                              @OA\Property(
     *                              property="label",
     *                              type="string",
     *                              example="Next & raquo;"
     *                              ),
     *                              @OA\Property(
     *                              property="active",
     *                              type="boolean",
     *                              example=false
     *                              ),
     *                         ),
     *                     ),
     *                     @OA\Property(
     *                         property="next_page_url",
     *                         type="string",
     *                         example="/?page=2"
     *                     ),
     *                     @OA\Property(
     *                         property="path",
     *                         type="string",
     *                         example="/"
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="prev_page_url",
     *                         type="string",
     *                         example="/?page=1"
     *                     ),
     *                     @OA\Property(
     *                         property="to",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=30
     *                     ),
     *                 ),
     *             )
     *     )
     * )
     * @return JsonResponse
     */

    public function index()
    {
        return $this->service->getAll();
    }

    /** @OA\Post(
     *     path="/api/admin/admins",
     *     description="Store admin",
     *     summary="Store",
     *     operationId="storeAdmin",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin"},
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
     *                     example="admin@admin.com"
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
     *         description="Admin created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Admin created successfully"
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

    public function store(StoreRequest $request)
    {
        $this->service->register($request->validated());

        return $this->success([], null, trans('messages.admin_create_success'));
    }

    /** @OA\Get(
     *     path="/api/admin/admins/{user}",
     *     description="Get Admin",
     *     summary="Get by id",
     *     operationId="getAdmin",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
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
     *                         @OA\Schema(ref="#/components/schemas/User")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param User $user
     * @return JsonResponse
     */

    public function show($id)
    {
        $user = User::with('roles')->where('id', $id)->first();
        return $this->success($user, $this->transformer);
    }

    /** @OA\Put(
     *     path="/api/admin/admins/{user}",
     *     description="Update admin",
     *     summary="Update",
     *     operationId="updateAdmin",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin"},
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
     *                     property="name",
     *                     type="string",
     *                     example="elon"
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
     *                     example="Admin updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/User")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param User $user
     * @return JsonResponse
     */

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        $this->service->update($request->validated(), $user);
        return $this->success($user, $this->transformer, trans('messages.update_admin_account'));
    }

    /** @OA\Delete(
     *     path="/api/admin/admins/{user}",
     *     description="Delete collection item type",
     *     summary="Delete",
     *     operationId="deleteAdmin",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
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
     *                     example="Admin Deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param User $user
     * @return JsonResponse
     */

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return $this->success([], null, trans('messages.admin_delete_success'));
        }
        return $this->success([], null, trans('messages.admin_doesnot_exist'));
    }
}
