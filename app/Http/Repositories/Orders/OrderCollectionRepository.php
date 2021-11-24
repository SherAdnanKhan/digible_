<?php

namespace App\Http\Repositories\Orders;

use App\Models\CollectionItemOrder;

class OrderCollectionRepository
{
    public function create($order, $data)
    {
        $order->collectionItem()->attach($data['collection_item_id'], ['quantity' => $data['quantity']]);
        $orderResv = CollectionItemOrder::where('order_id' , $order->id)->first()->toArray();
        return $orderResv;
    }
}
