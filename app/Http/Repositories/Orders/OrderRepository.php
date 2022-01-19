<?php

namespace App\Http\Repositories\Orders;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderRepository
{
    public function getPendings()
    {
        return Order::whereHas('transactions', function ($query) {
            return $query->where('created_at', '>=', Carbon::now()->addHours(-8)->format('Y-m-d H:i:s'))
                ->where('status', Order::PENDING)->where('user_id', auth()->user()->id);
        })->get();
    }

    public function create($data)
    {
        $order = Order::create($data);
        return $order;
    }

    public function update($order)
    {
        $order->update(['status' => Order::COMPLETED]);
    }

    public function getall()
    {
        return Order::with('user', 'transactions', 'orderDetails', 'orderDetails.collectionitem')->get();
    }

    public function getSellerData(User $user)
    {
        return Order::where(['seller_id' => $user->id, 'status' => Order::COMPLETED])->with('seller', 'user', 'transactions', 'orderDetails', 'orderDetails.collectionitem.collection', 'orderDetails.collectionitem.collection.user', 'orderDetails.collectionitem.lastPurchasedBet')->get();
    }

    public function getBuyerData(User $user)
    {
        return Order::where(['user_id' => $user->id, 'status' => Order::COMPLETED])->with('user', 'seller', 'transactions', 'orderDetails', 'orderDetails.collectionitem', 'orderDetails.collectionitem.collection', 'orderDetails.collectionitem.collection.user', 'orderDetails.collectionitem.lastPurchasedBet')->get();
    }
}
