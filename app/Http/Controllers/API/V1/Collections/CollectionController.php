<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectionSaveRequest;
use App\Http\Requests\Collections\CollectionUpdateRequest;
use App\Http\Services\Collections\CollectionService;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(CollectionService $service, CollectionTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /** @OA\Get(
     *     path="/api/collections",
     *     description="Get Collections",
     *     summary="Get all",
     *     operationId="getCollections",
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
     *                     @OA\Items(ref="#/components/schemas/Collection")
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
     *     path="/api/collections",
     *     description="Store Collection",
     *     summary="Store",
     *     operationId="storeCollection",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Pokeman Card"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="pending"
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
     *                     example="Collection created successfully"
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

    public function store(CollectionSaveRequest $request): JsonResponse
    {
        $result = $this->service->save($request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_create_success'));
    }

    /** @OA\Get(
     *     path="/api/collections/{collection}",
     *     description="Get Collection",
     *     summary="Get by id",
     *     operationId="getCollection",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
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
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/Collection")
     *                     }
     *                  ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @return JsonResponse
     */

    public function show(Collection $collection)
    {
        return $this->success($collection, $this->transformer);
    }

    /** @OA\Put(
     *     path="/api/collections/{collection}",
     *     description="Update Collection",
     *     summary="Update",
     *     operationId="UpdateCollection",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
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
     *                     example="Pokeman Card "
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="pending"
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
     *                     example="Collection updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/Collection")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Collection $collection
     * @return JsonResponse
     */

    public function update(CollectionUpdateRequest $request, Collection $collection)
    {
        $result = $this->service->update($collection, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_update_success'));
    }

    /** @OA\Delete(
     *     path="/api/collections/{collection}",
     *     description="Delete Collection",
     *     summary="Delete",
     *     operationId="DeleteCollection",
     *     security={{"bearerAuth":{}}},
     *     tags={"Collections"},
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
     *                     property="message",
     *                     type="string",
     *                     example="Collection Deleted successfully"
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

    public function destroy(Collection $collection)
    {
        $this->service->delete($collection);
        return $this->success([], null, trans('messages.collection_delete_success'));
    }
}
