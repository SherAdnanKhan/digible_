<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\CollectionItem;
use App\Http\Controllers\Controller;
use App\Http\Services\Collections\CollectionItemService;
use App\Http\Requests\Collections\Seller\CollectionItemUpdateRequest;

class SellerCollectionItemController extends Controller
{
    protected $service;

    public function __construct(CollectionItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionItemUpdateRequest $request, Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->updateAFS($collectionItem, $request->validated());
        return $this->success([], null, trans('messages.collection_item_update_success'));
    }

}
