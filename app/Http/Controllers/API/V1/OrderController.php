<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderCompleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Services\Users\OrderService;
use App\Http\Transformers\Orders\OrderTransformer;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(OrderService $service, OrderTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/orders/pending",
     *     description="Get pending orders",
     *     summary="Get pending orders",
     *     operationId="getPendingOrders",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
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
     *                     @OA\Items(ref="#/components/schemas/Order")
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
        return $this->service->getPendings();
    }

    /** @OA\Post(
     *     path="/api/orders/checkout",
     *     description="Store orders",
     *     summary="Store",
     *     operationId="StoreOrder",
     *     security={{"bearerAuth":{}}},
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *         @OA\Property(
     *           property="authenication",
     *           type="object",
     *           @OA\Property(
     *             property="api_key",
     *             type="string",
     *             default=1,
     *             example="Key123"
     *             ),
     *           @OA\Property(
     *             property="api_pass",
     *             type="string",
     *             default=1,
     *             example="pass123"
     *             )
     *         ),

     *             @OA\Property(
     *                property="items",
     *                type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="collection_item_id",
     *                         type="string",
     *                         example=1
     *                      ),
     *                      @OA\Property(
     *                         property="quantity",
     *                         type="string",
     *                         example=5
     *                      ),
     *                      @OA\Property(
     *                         property="discount",
     *                         type="string",
     *                         example=2
     *                      ),
     *                      @OA\Property(
     *                         property="currency",
     *                         type="number",
     *                         example="USD"
     *                      ),
     *                ),
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="collection_item_id",
     *                         type="string",
     *                         example=2
     *                      ),
     *                      @OA\Property(
     *                         property="quantity",
     *                         type="string",
     *                         example=5
     *                      ),
     *                      @OA\Property(
     *                         property="discount",
     *                         type="string",
     *                         example=20
     *                      ),
     *                      @OA\Property(
     *                         property="currency",
     *                         type="number",
     *                         example="USD"
     *                      ),
     *                ),
     *             ),
     *             ),
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
     *                     example="Order created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Order $order
     * @return JsonResponse
     */

    public function store(OrderRequest $request)
    {
        $result = $this->service->create($request->validated());
        if ($result) {
            return $this->success([], $this->transformer, trans('messages.order_create_success'));
        } else {
            return $this->failure('', trans('messages.order_create_failed'));
        }
    }
    

    public function update(Order $order, OrderCompleteRequest $request)
    {
        $result = $this->service->completed($order, $request->validated());
    }

}
