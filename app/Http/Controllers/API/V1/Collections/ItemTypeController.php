<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\ItemTypeSaveRequest;
use App\Http\Requests\Collections\ItemTypeUpdateRequest;
use App\Http\Services\Collections\ItemTypeService;
use App\Http\Transformers\Collections\ItemTypeTransformer;
use App\Models\CollectionItemType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;
    protected $transformer;

    public function __construct(ItemTypeService $service, ItemTypeTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/admin/collection-item-types",
     *     description="Get collection item types",
     *     summary="Get all",
     *     operationId="getCollectionItemTypes",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Item Types"},
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

    public function index()
    {
        $data= $this->service->getAll();
        return $this->success($data, null);
    }

    /** @OA\Post(
     *     path="/api/admin/collection-item-types",
     *     description="Store collection item types",
     *     summary="Store",
     *     operationId="storeCollectionItemType",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Item Types"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Stamps"
     *                 ),
     *                 @OA\Property(
     *                     property="label",
     *                     type="string",
     *                     example="stamp"
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
     *                     example="Collection item type created successfully"
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

    public function store(ItemTypeSaveRequest $request): JsonResponse
    {
        $result = $this->service->save($request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_item_type_create_success'));
    }

    /** @OA\Get(
     *     path="/api/admin/collection-item-types/{collectionItemType}",
     *     description="Get collection item type",
     *     summary="Get by id",
     *     operationId="getCollectionItemType",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Item Types"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="collectionItemType",
     *         parameter="collectionItemType",
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
     * @param CollectionItemType $collectionItemType
     * @return JsonResponse
     */

    public function show(CollectionItemType $collectionItemType): JsonResponse
    {
        return $this->success($collectionItemType, $this->transformer);
    }

    /** @OA\Put(
     *     path="/api/admin/collection-item-types/{collectionItemType}",
     *     description="Update collection item type",
     *     summary="Update",
     *     operationId="updateCollectionItemType",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Item Types"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="collectionItemType",
     *         parameter="collectionItemType",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Stamps"
     *                 ),
     *                 @OA\Property(
     *                     property="label",
     *                     type="string",
     *                     example="stamp"
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
     *                     example="Collection item type updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/CollectionItemType")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CollectionItemType $collectionItemType
     * @return JsonResponse
     */

    public function update(ItemTypeUpdateRequest $request, CollectionItemType $collectionItemType): JsonResponse
    {
        $result = $this->service->update($collectionItemType, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_item_type_update_success'));
    }

    /** @OA\Delete(
     *     path="/api/admin/collection-item-types/{collectionItemType}",
     *     description="Delete collection item type",
     *     summary="Delete",
     *     operationId="deleteCollectionItemType",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collection Item Types"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="collectionItemType",
     *         parameter="collectionItemType",
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
     *                     example="Collection item type Deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CollectionItemType $collectionItemType
     * @return JsonResponse
     */

    public function destroy(CollectionItemType $collectionItemType): JsonResponse
    {
        $this->service->delete($collectionItemType);
        return $this->success([], null, trans('messages.collection_item_type_delete_success'));
    }
}
