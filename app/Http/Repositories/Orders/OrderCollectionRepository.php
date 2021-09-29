<?php

namespace App\Http\Repositories\Orders;

class OrderCollectionRepository
{
    public function create($order, $data)
    {
        $order->collectionItem()->attach($data['collection_item_id'],['quantity'=> $data['quantity']]);
    }
}
