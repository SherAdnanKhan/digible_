<?php

namespace App\Http\Repositories\Orders;

use App\Models\OrderTransaction;

class OrderTransactionRepository
{
    public function success($order, $data, $response)
    {
        $order->transactions()->create([
            'payment_id' => 'todoPayment_id',
            'transaction_type' => $data['transaction_type'],
            'transaction_number' => 'todoRefnumber',
            'status' => OrderTransaction::SUCCESS,
            'currency' => $data['currency'],
            'total' => $order->total,
        ]);
    }

    public function failed($order, $data, $response)
    {
        $order->transactions()->create([
            'payment_id' => 'todoPayment_id',
            'transaction_type' => $data['transaction_type'],
            'transaction_number' => 'todoRefnumber',
            'status' => OrderTransaction::FAILED,
            'currency' => $data['currency'],
            'total' => $order->total,
        ]);
    }

    public function salesDetails()
    {
        return OrderTransaction::with('transaction', 'collectionItem')->get();
    }
}
