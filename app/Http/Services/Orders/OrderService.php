<?php

namespace App\Http\Services\Users;

use App\Models\User;
use App\Models\Order;
use App\Models\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\CollectionItem;
use App\Models\OrderTransaction;
use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use App\Http\Repositories\Orders\OrderRepository;
use App\Http\Services\Payment\PaymentGateService;
use App\Http\Repositories\Orders\OrderCollectionRepository;
use App\Http\Repositories\Orders\OrderTransactionRepository;

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

    public function getPendings()
    {
        Log::info(__METHOD__ . " --pending transaction data all fetched: ");
        return $this->orderRepository->getPendings();
        // return $this->paymentGateService->paginate($result);
    }

    public function create(array $data)
    {
        $items = $data['items'];
        foreach ($items as $item) {;
            $collectionItem[$item['collection_item_id']] = CollectionItem::find($item['collection_item_id']);
            $seller[$item['collection_item_id']] = Collection::where('user_id',$collectionItem[$item['collection_item_id']]->collection_id)->pluck('user_id')->first();
        }
        foreach ($items as $item) {
            if ($collectionItem[$item['collection_item_id']]->available_for_sale == 1) {
                $subtotal = $collectionItem[$item['collection_item_id']]->price * $item['quantity'];
                $discount = Arr::exists($item, 'discount') ? $item['discount'] : 0.00;
                $subtotalAfterDiscount = $subtotal - $discount;
                if ($subtotalAfterDiscount < 0) {
                    throw new ErrorException('exception.total_is_negative');
                }
                $tax = config('app.tax') / 100;
                $productTax = round($subtotalAfterDiscount * $tax, 2);
                $total = $subtotalAfterDiscount + $productTax;

                $orderItem['ref_id'] = 'ORD-' . Str::random(15);
                $orderItem['seller_id'] = $seller[$item['collection_item_id']];
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
                    $this->orderRepository->update($order);
                    $this->orderTransactionRepository->success($order, $item, $response);
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
            $this->orderRepository->update($order);
            $this->orderTransactionRepository->success($order, $data, $response);
            return true;
        } else {
            $this->orderTransactionRepository->failed($order, $data, $response);
            return false;
        }
    }

    public function getall()
    {
        Log::info(__METHOD__ . " -- transaction data all fetched: ");
        return $this->orderRepository->getall();
        // return $this->paymentGateService->paginate($result);
    }

    public function getSellerData(User $user)
    {
        Log::info(__METHOD__ . " --Seller transaction data all fetched: ");
        return $this->orderRepository->getSellerData($user);
        // return $this->paymentGateService->paginate($result);
    }

    public function getBuyerData(User $user)
    {
        Log::info(__METHOD__ . " --Buyer transaction data all fetched: ");
        return $this->orderRepository->getBuyerData($user);
        // return $this->paymentGateService->paginate($result);
    }

}
