<?php

namespace App\Http\Repositories\Orders;

use App\Models\Auction;
use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\Event;

class OrderTransactionRepository
{
    public function success($order, $data, $response)
    {
        $order->update(['purchased_at' => now()]);
        if (!$order->transactions()->exists()) {
            $order->transactions()->create([
                'payment_id' => 'todoPayment_id',
                'transaction_type' => $data['transaction_type'],
                'transaction_number' => 'todoRefnumber',
                'status' => OrderTransaction::SUCCESS,
                'currency' => $data['currency'],
                'total' => $order->total,
            ]);
        }
        $item = CollectionItem::find($data['collection_item_id']);
        $item->available_for_sale = 3;
        $item->save();
        $exist_item = CollectionItem::where([['collection_id', $item['collection_id']], ['available_for_sale', '!=', 3]])->first();

        if (!$exist_item) {
            Collection::where('id', $item['collection_id'])->update(['status' => Collection::STATUS_SOLD]);
            $collection = Collection::where('id', $item['collection_id'])->first();
            Event::dispatch('collection.sold', [$collection]);
        }
        if (isset($data['auction'])) {
            $item->lastWonBet()->first()->update(['status' => Auction::STATUS_PURCHASED]);
            $item->pendingAuction()->update(['status' => Auction::STATUS_LOST]);
        }
    }

    public function failed($order, $data, $response)
    {
        if (!$order->transactions()->exists()) {
            $order->transactions()->create([
                'payment_id' => 'todoPayment_id',
                'transaction_type' => $data['transaction_type'],
                'transaction_number' => 'todoRefnumber',
                'status' => OrderTransaction::FAILED,
                'currency' => $data['currency'],
                'total' => $order->total,
            ]);
        }
    }

}
