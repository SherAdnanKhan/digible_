<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectionItemSaveRequest;
use App\Http\Requests\Collections\CollectionItemUpdateRequest;
use App\Http\Services\Collections\CollectionItemService;
use App\Http\Transformers\Collections\CollectionItemTransformer;
use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionItemController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(CollectionItemService $service, CollectionItemTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/collections/{collection}/collection-items/",
     *     description="Get Collection Items",
     *     summary="Get all",
     *     operationId="getCollectionItems",
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
     *                     @OA\Items(ref="#/components/schemas/CollectionItem")
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
     * @param Collection $collection
     * @return JsonResponse
     */

    public function index(Collection $collection)
    {
        return $this->service->getAll($collection);
    }

    /** @OA\Post(
     *     path="/api/collections/{collection}/collection-items/",
     *     description="Store Collection Item",
     *     summary="Store",
     *     operationId="StoreCollectionItem",
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Cresseliaa"
     *                 ),
     *                 @OA\Property(
     *                     property="collection_item_type_id",
     *                     type="integer",
     *                     example="6"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="this is pokeman item has 160 physical asset"
     *                 ),
     *                 @OA\Property(
     *                     property="edition",
     *                     type="string",
     *                     example="ist"
     *                 ),
     *                 @OA\Property(
     *                     property="graded",
     *                     type="string",
     *                     example="yes"
     *                 ),
     *                 @OA\Property(
     *                     property="year",
     *                     type="date",
     *                     example="2019-03-10 02:00:39"
     *                 ),
     *                 @OA\Property(
     *                     property="population",
     *                     type="string",
     *                     example="4"
     *                 ),
     *                 @OA\Property(
     *                     property="publisher",
     *                     type="string",
     *                     example="Pokeman"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="double",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="pending"
     *                 ),
     *                 @OA\Property(
     *                     property="available_for_sale",
     *                     type="boolean",
     *                     example=0
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
     *                     example="Collection Item created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @return JsonResponse
     */

    public function store(CollectionItemSaveRequest $request, Collection $collection): JsonResponse
    {
        $result = $this->service->save($collection, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_item_create_success'));
    }

    /** @OA\Get(
     *     path="/api/collections/{collection}/collection-items/{collectionItem}",
     *     description="Get Collection Item",
     *     summary="Get by id",
     *     operationId="GetCollectionItem",
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
     *                         @OA\Schema(ref="#/components/schemas/CollectionItem")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @param CollectionItem $collectionitem
     * @return JsonResponse
     */

    public function show(Collection $collection, CollectionItem $collectionItem): JsonResponse
    {
        return $this->success($collectionItem, $this->transformer);
    }

    /** @OA\Put(
     *     path="/api/collections/{collection}/collection-items/{collectionItem}",
     *     description="Update Collection Item",
     *     summary="Update",
     *     operationId="UpdateCollectionItem",
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
     *                     property="name",
     *                     type="string",
     *                     example="Cresselia"
     *                 ),
     *                 @OA\Property(
     *                     property="collection_item_type_id",
     *                     type="integer",
     *                     example="6"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="this is pokeman item has 160 physical asset"
     *                 ),
     *                 @OA\Property(
     *                     property="edition",
     *                     type="string",
     *                     example="ist"
     *                 ),
     *                 @OA\Property(
     *                     property="graded",
     *                     type="string",
     *                     example="yes"
     *                 ),
     *                 @OA\Property(
     *                     property="year",
     *                     type="date",
     *                     example="2019-03-10 02:00:39"
     *                 ),
     *                 @OA\Property(
     *                     property="population",
     *                     type="string",
     *                     example="4"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="double",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="publisher",
     *                     type="string",
     *                     example="Pokeman"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="pending"
     *                 ),
     *                 @OA\Property(
     *                     property="available_for_sale",
     *                     type="boolean",
     *                     example=0
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
     *                     example="Collection Item Updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/CollectionItem")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @param CollectionItem $collectionitem
     * @return Json
     */

    public function update(CollectionItemUpdateRequest $request, Collection $collection, CollectionItem $collectionItem): JsonResponse
    {
        $result = $this->service->update($collectionItem, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_item_update_success'));
    }

    /** @OA\Delete(
     *     path="/api/collections/{collection}/collection-items/{collectionItem}",
     *     description="Delete Collection Item",
     *     summary="Delete",
     *     operationId="DeleteCollectionItem",
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
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Collection Item Deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @param CollectionItem $collectionitem
     * @return JsonResponse
     */

    public function destroy(Collection $collection, CollectionItem $collectionItem): JsonResponse
    {
        if ($collection && $collectionItem->collection_id == $collection->id &&
            (auth()->user()->hasRole('admin') || auth()->user()->id == $collection->user_id)) {
            $this->service->delete($collectionItem);
            return $this->success([], null, trans('messages.collection_item_delete_success'));
        }
        return $this->failure('', trans('messages.unauthorize_user_delete'));

    }
}
