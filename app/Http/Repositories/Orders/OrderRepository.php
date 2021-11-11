<?php

namespace App\Http\Repositories\Orders;

use App\Models\Order;
use App\Models\OrderTransaction;
use Carbon\Carbon;

class OrderRepository
{
    public function getPendings()
    {
        return Order::whereHas('transactions', function ($query) {
            return $query->where('created_at', '>=', Carbon::now()->addHours(-8)->format('Y-m-d H:i:s'))
                ->where('status', 1)->where('user_id', auth()->user()->id);
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
}
