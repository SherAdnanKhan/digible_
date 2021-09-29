<?php
namespace App\Http\Transformers\Orders;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\Order;

class OrderTransformer extends BaseTransformer
{
    protected $defaultIncludes = ['status'];

    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'ref_id' => $order->ref_id,
            'user_id' => $order->user_id,
            'payment_method_id' => $order->payment_method_id,
            'discount' => $order->discount,
            'subtotal' => $order->subtotal,
            'tax' => $order->tax,
            'total' => $order->total,
            'currency' => $order->currency,
            'order_status' => $order->order_status,
        ];
    }

     public function includeUser(Order $order)
    {
        $user = $order->user;
        return $this->item($user, new UserTransformer);
    }

    public function includeStatus(Order $order)
    {
        $item = [
            'id' => $order->id,
            'name' => data_get(Order::statuses(), $order->order_status),
        ];

        return $this->item($item, new ConstantTransformer);
    }

}
