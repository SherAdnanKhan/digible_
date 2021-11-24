<?php

namespace App\Http\Controllers\API\V1\Auction;

use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Auctions\AuctionService;
use App\Http\Requests\Auction\AuctionSaveRequest;
use App\Http\Transformers\Auctions\AuctionTransformer;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;
    protected $transformer;

    public function __construct(AuctionService $service, AuctionTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/auctions/",
     *     description="Get auctions details",
     *     summary="Get all",
     *     operationId="getAuctions",
     *     security={{"bearerAuth":{}}},
     *     tags={"Auctions"},
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
     *                     @OA\Items(ref="#/components/schemas/CollectionItemType")
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

    public function getWonBets()
    {
        return $this->service->getWonBets();
    }

    /** @OA\Post(
     *     path="/api/auctions",
     *     description="Store auctions",
     *     summary="Store",
     *     operationId="storeAuction",
     *     security={{"bearerAuth":{}}},
     *     tags={"Auctions"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="collection_item_id",
     *                     type="string",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="last_price",
     *                     type="double",
     *                     example=5.0
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
     *                     example="Auction request created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */

    public function store(AuctionSaveRequest $request): JsonResponse
    {
        $result = $this->service->save($request->validated());
        if($result){
            return $this->success([], null, trans('messages.auction_created_success'));
        }
        return $this->failure('', trans('messages.messages.auction_place_failed'));
    }

    /** @OA\Get(
     *     path="/api/auctions/{auction}",
     *     description="Get auction",
     *     summary="Get by id",
     *     operationId="getAuction",
     *     security={{"bearerAuth":{}}},
     *     tags={"Auctions"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="auction",
     *         parameter="auction",
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
     *                         @OA\Schema(ref="#/components/schemas/CollectionItemType")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param Auction $auction
     * @return JsonResponse
     */

    public function show(Auction $auction): JsonResponse
    {
        return $this->success($auction, $this->transformer);
    }

        /** @OA\Get(
     *     path="/api/auction/current",
     *     description="Get auction",
     *     summary="Get by id",
     *     operationId="getAuction",
     *     security={{"bearerAuth":{}}},
     *     tags={"Auctions"},
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
     *                         @OA\Schema(ref="#/components/schemas/CollectionItemType")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param Auction $auction
     * @return JsonResponse
     */

    public function getByUser(User $user)
    {
        return $this->service->getByUser($user);
    }
    

}
