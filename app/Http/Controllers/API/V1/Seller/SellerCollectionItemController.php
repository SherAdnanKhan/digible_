<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\Seller\CollectionItemUpdateRequest;
use App\Http\Services\Collections\CollectionItemService;
use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Http\Request;

class SellerCollectionItemController extends Controller
{
    protected $service;

    public function __construct(CollectionItemService $service)
    {
        $this->service = $service;
    }

    /** @OA\Put(
     *     path="/api/sellers/collections/{collection}/collection-items/{collectionItem}",
     *     description="Update Item Available for Sale",
     *     summary="Item change Available for sale",
     *     operationId="updateAFS",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Items"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="collection",
     *         parameter="collection",
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="collectionItem",
     *         parameter="collectionItem",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="available_for_sale",
     *                     type="binary",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="available_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2021-09-27 18:50:00"
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
     *                     example="Collection item updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CollectionItem $collectionItem
     * @return Json
     */

    public function update(CollectionItemUpdateRequest $request, Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->updateAFS($collectionItem, $request->validated());
        return $this->success([], null, trans('messages.collection_item_update_success'));
    }

}
