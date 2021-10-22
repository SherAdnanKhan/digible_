<?php

namespace App\Http\Repositories\Orders;

use App\Models\Order;
use App\Models\OrderTransaction;
use Carbon\Carbon;

class OrderRepository
{
    public function getPendings()
    {
        $orTr = OrderTransaction::where('order_id', 11)->get();

        return Order::whereHas('transactions', function ($query) {
            return $query->where('created_at', '>=', Carbon::now()->addMinutes(-10)->format('Y-m-d H:i:s'))
                ->where('status', 1);
        })->get();
    }

    public function create($data)
    {
        $order = Order::create($data);
        return $order;
    }

    public function update($order)
    {
        $order->update(['order_status' => Order::COMPLETED]);
    }

    public function getall()
    {
        return Order::with('user', 'transactions', 'orderDetails', 'orderDetails.collectionitem')->get();
    }
}
