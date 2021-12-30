<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Favourites\FavouriteService;
use App\Http\Transformers\Collections\CollectionItemTransformer;
use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    protected $service;
    /**
     * @var CollectionItemTransformer
     */
    private $collectionItemTransformer;

    public function __construct(FavouriteService $service, CollectionItemTransformer $collectionItemTransformer)
    {
        $this->service = $service;
        $this->collectionItemTransformer = $collectionItemTransformer;
    }

    /** @OA\Post(
     *     path="/api/collections/{collection}/favourite/{collectionItem}",
     *     description="Favourite a item",
     *     summary="Favourite Item",
     *     operationId="favouriteItem",
     *     security={{"bearerAuth":{}}},
     *     tags={"Favourites"},
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
     *                     example="Collection item favourited successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Favourite $favourite
     * @return JsonResponse
     */

    public function favourite(Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->favourite($collectionItem);
        return $this->success([], null, trans('messages.collection_item_favourite_success'));
    }

        /** @OA\get(
     *     path="/api/is_favorite/{collectionItem}",
     *     description="Is item Favourite",
     *     summary="Is Item Favourite?",
     *     operationId="isFavorite",
     *     security={{"bearerAuth":{}}},
     *     tags={"Favourites"},
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
     *                     example="success"
     *                 ),
     *                  @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                           @OA\Property(
     *                           property="isfavourite",
     *                           type="string",
     *                           example=true
     *                           ),
     *                      ),),
     *             )
     *         )
     *     )
     * )
     * @param Favourite $favourite
     * @return JsonResponse
     */

    public function isFavorite(CollectionItem $collectionItem)
    {
        $isFavourite=(object) ['isfavourite' => Auth::user()->favourites->contains($collectionItem->id)];
        return $this->success([$isFavourite], null);
    }

    /** @OA\Post(
     *     path="/api/collections/{collection}/unfavourite/{collectionItem}",
     *     description="Unfavourite a item",
     *     summary="Unfavourite Item",
     *     operationId="unfavouriteItem",
     *     security={{"bearerAuth":{}}},
     *     tags={"Favourites"},
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
     *                     example="Collection item unfavourited successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param Favourite $favourite
     * @return JsonResponse
     */

    public function unFavourite(Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->unFavourite($collectionItem);
        return $this->success([], null, trans('messages.collection_item_unfavourite_success'));
    }

    /** @OA\Get(
     *     path="/api/my_favorites",
     *     description="Get my favourites",
     *     summary="get all favourite",
     *     operationId="GetFavourite",
     *     security={{"bearerAuth":{}}},
     *     tags={"Favourites"},
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
     *                     @OA\Items(ref="#/components/schemas/Favourite")
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
     * @param Favourite $favourite
     * @return JsonResponse
     */

    public function myFavorites(CollectionItem $collectionItem)
    {
        $result = $this->service->myFavorites($collectionItem);
        return $this->success($result, $this->collectionItemTransformer);
    }
}
