<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sellers\CreateRequest;
use App\Http\Requests\Sellers\ReverifyCreateRequest;
use App\Http\Services\Sellers\SellerRequestService;
use App\Http\Transformers\Sellers\SellerTransformer;
use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerRequestController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(SellerRequestService $service, SellerTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Post(
     *     path="/api/users/seller-verify-request",
     *     description="Store seller data",
     *     summary="Seller data store",
     *     operationId="StoreSellerData",
     *     security={{"bearerAuth":{}}},
     *     tags={"Sellers"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *              @OA\Property(
     *                  property="surname",
     *                  type="string",
     *                  example="ben"
     *              ),
     *              @OA\Property(
     *                  property="wallet_address",
     *                  type="string",
     *                  example="0xfbed75735e69c0b78fd70730ae92bd2b075cec2f"
     *              ),
     *              @OA\Property(
     *                  property="phone_no",
     *                  type="string",
     *                  example="+1-202-555-0180"
     *              ),
     *              @OA\Property(
     *                  property="twitter_link",
     *                  type="string",
     *                  example="https: //twitter.com/digible"
     *              ),
     *              @OA\Property(
     *                  property="insta_link",
     *                  type="string",
     *                  example="https: //www.instagram.com/digible"
     *              ),
     *              @OA\Property(
     *                  property="twitch_link",
     *                  type="string",
     *                  example="https: //www.twitch.tv/digible"
     *              ),
     *              @OA\Property(
     *                  property="type",
     *                  type="string",
     *                  example="individual"
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  example="pending/approved"
     *              ),
     *              @OA\Property(
     *                  property="address",
     *                  type="string",
     *                  example="87214 Margarita Radial"
     *              ),
     *              @OA\Property(
     *                  property="address2",
     *                  type="string",
     *                  example="87214 Margarita Radial"
     *              ),
     *              @OA\Property(
     *                  property="country",
     *                  type="string",
     *                  example="USA"
     *              ),
     *              @OA\Property(
     *                  property="state",
     *                  type="string",
     *                  example="Bilzen"
     *              ),
     *              @OA\Property(
     *                  property="city",
     *                  type="string",
     *                  example="Hoppeshire"
     *              ),
     *              @OA\Property(
     *                  property="postalcode",
     *                  type="string",
     *                  example="22186"
     *              ),
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
     *                     example="Seller request created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param SellerProfile $sellerProfile
     * @return JsonResponse
     */

    public function store(CreateRequest $request): JsonResponse
    {
        $user = auth()->user();
        if ($user->sellerProfile) {
            return $this->failure([], trans('messages.seller_request_exist'));
        }
        $result = $this->service->save($request->validated());
        return $this->success($result, $this->transformer, trans('messages.seller_request_create_success'));
    }

    /** @OA\Get(
     *     path="api/get-seller-verify-request",
     *     description="Get Seller Request",
     *     summary="Get Seller Request",
     *     operationId="getSellerRequest",
     *     security={{"bearerAuth":{}}},
     *     tags={"Sellers"},
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
     *                         @OA\Schema(ref="#/components/schemas/SellerProfile")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param SellerProfile $sellerProfile
     * @return JsonResponse
     */

    public function index()
    {
        $result = $this->service->getCurrent();
        if(count($result)>0){
        return $this->success($result, $this->transformer);
        }
        return $this->failure([], trans('messages.seller_request_not_found'));
    }

    /** @OA\Put(
     *     path="/api/seller-reverify-request/{sellerProfile}",
     *     description="Reverify Seller Request",
     *     summary="Reverify Seller Request",
     *     operationId="ReverifySellerRequest",
     *     security={{"bearerAuth":{}}},
     *     tags={"Sellers"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="sellerProfile",
     *         parameter="sellerProfile",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(
     *                   property="id_image",
     *                   type="string",
     *                   format="string",
     *                   example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=="
     *               ),
     *               @OA\Property(
     *                   property="address_image",
     *                   type="string",
     *                   format="string",
     *                   example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=="
     *               ),
     *               @OA\Property(
     *                   property="insurance_image",
     *                   type="string",
     *                   format="string",
     *                   example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=="
     *               ),
     *               @OA\Property(
     *                   property="code_image",
     *                   type="string",
     *                   format="string",
     *                   example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=="
     *               ),
     *               @OA\Property(
     *                   property="surname",
     *                   type="string",
     *                   example="ben"
     *               ),
     *               @OA\Property(
     *                   property="wallet_address",
     *                   type="string",
     *                   example="0xfbed75735e69c0b78fd70730ae92bd2b075cec2f"
     *               ),
     *               @OA\Property(
     *                   property="address",
     *                   type="string",
     *                   example="3th Street. 47 W 13th St, New York"
     *               ),
     *               @OA\Property(
     *                   property="address2",
     *                   type="string",
     *                   example="3th Street. 47 W 13th St, New York"
     *               ),
     *               @OA\Property(
     *                   property="country",
     *                   type="string",
     *                   example="India"
     *               ),
     *               @OA\Property(
     *                   property="city",
     *                   type="string",
     *                   example="mumbai"
     *               ),
     *               @OA\Property(
     *                   property="state",
     *                   type="string",
     *                   example="Kerla"
     *               ),
     *               @OA\Property(
     *                   property="postalcode",
     *                   type="string",
     *                   example="1234"
     *               ),
     *               @OA\Property(
     *                   property="phone_no",
     *                   type="string",
     *                   example="+1-202-555-0180"
     *               ),
     *               @OA\Property(
     *                   property="twitter_link",
     *                   type="string",
     *                   example="https: //twitter.com/digible"
     *               ),
     *               @OA\Property(
     *                   property="insta_link",
     *                   type="string",
     *                   example="https: //www.instagram.com/digible"
     *               ),
     *               @OA\Property(
     *                   property="twitch_link",
     *                   type="string",
     *                   example="https: //www.twitch.tv/digible"
     *               ),
     *               @OA\Property(
     *                   property="type",
     *                   type="string",
     *                   example="individual"
     *               ),
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
     *                     example="Seller request created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param SellerProfile $sellerProfile
     * @return JsonResponse
     */

    public function update(SellerProfile $sellerProfile, ReverifyCreateRequest $request): JsonResponse
    {
        $result = $this->service->reSave($sellerProfile, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.seller_request_recreate_success'));
    }
}
