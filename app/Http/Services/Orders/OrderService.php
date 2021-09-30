<?php

namespace App\Http\Services\Users;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Orders\OrderCollectionRepository;
use App\Http\Repositories\Orders\OrderRepository;
use App\Http\Repositories\Orders\OrderTransactionRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Payment\PaymentGateService;
use App\Models\CollectionItem;
use App\Models\Order;
use App\Models\OrderTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService extends BaseService
{
    protected $paymentGateService;
    protected $orderRepository;
    protected $orderCollectionRepository;
    protected $orderTransactionRepository;

    public function __construct(PaymentGateService $paymentGateService,
        OrderRepository $orderRepository, OrderCollectionRepository $orderCollectionRepository,
        OrderTransactionRepository $orderTransactionRepository) {
        $this->paymentGateService = $paymentGateService;
        $this->orderRepository = $orderRepository;
        $this->orderCollectionRepository = $orderCollectionRepository;
        $this->orderTransactionRepository = $orderTransactionRepository;
    }

    public function create(array $data)
    {
        $items = $data['items'];
        foreach ($items as $item) {
            $collectionItem = CollectionItem::find($item['collection_item_id']);
            if ($collectionItem->available_for_sale == 1) {
                $subtotal = $collectionItem->price * $item['quantity'];
                $discount = Arr::exists($item, 'discount') ? $item['discount'] : 0.00;
                $subtotalAfterDiscount = $subtotal - $discount;
                if ($subtotalAfterDiscount < 0) {
                    throw new ErrorException('exception.total_is_negative');
                }
                $tax = config('app.tax') / 100;
                $productTax = round($subtotalAfterDiscount * $tax, 2);
                $total = $subtotalAfterDiscount + $productTax;

                $orderItem['ref_id'] = 'ORD-' . Str::random(15);
                $orderItem['user_id'] = auth()->id();
                $orderItem['discount'] = $discount;
                $orderItem['subtotal'] = $subtotal;
                $orderItem['tax'] = $productTax;
                $orderItem['total'] = $total;
                $orderItem['status'] = Order::PENDING;
                $order = $this->orderRepository->create($orderItem);

                $this->orderCollectionRepository->create($order, $item);
                $item['transaction_type'] = OrderTransaction::DEBIT;

                $response = $this->paymentGateService->transaction($total, $data['authenication']);
                $emailData['item'] = $collectionItem;
                $emailData['order'] = $order;
                if ($response) {
                    $this->orderTransactionRepository->success($order, $item, $response);
                    $collectionItem->update(['available_for_sale' => 0]);
                    Event::dispatch('orders.success', [$emailData]);
                } else {
                    $this->orderTransactionRepository->failed($order, $item, $response);
                    Event::dispatch('orders.failed', [$emailData]);
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function completed(Order $order, $data)
    {
        $data['transaction_type'] = OrderTransaction::DEBIT;
        $response = $this->paymentGateService->transaction($order->total, $data['authenication']);
        if ($response) {
            return $this->orderTransactionRepository->success($order, $data, $response);
        } else {
            return $this->orderTransactionRepository->failed($order, $data, $response);
        }
    }

    public function getall()
    {
        Log::info(__METHOD__ . " -- transaction data all fetched: ");
        $result = $this->orderRepository->getall();
        return $this->paymentGateService->paginate($result);
    }

}
