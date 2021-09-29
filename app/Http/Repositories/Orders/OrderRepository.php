<?php

namespace App\Http\Repositories\Orders;

use App\Models\Order;

class OrderRepository
{
    public function create($data)
    {
        $order = Order::create($data);
        return $order;
    }

    public function update($order)
    {
        $order->update(['order_status' => Order::COMPLETED]);
    }

}
