<?php

namespace App\Http\Services\Orders;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Orders\OrderCollectionRepository;
use App\Http\Repositories\Orders\OrderRepository;
use App\Http\Repositories\Orders\OrderTransactionRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Payment\PaymentGateService;
use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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

    public function getPendings()
    {
        Log::info(__METHOD__ . " --pending transaction data all fetched: ");
        return $this->orderRepository->getPendings();
        // return $this->paymentGateService->paginate($result);
    }

    public function create(array $data)
    {
        try {
            $items = $data['items'];
            $grandTotal = 0;
            $result = [];
            foreach ($items as $item) {
                $collectionItem[$item['collection_item_id']] = CollectionItem::find($item['collection_item_id']);
                $seller[$item['collection_item_id']] = Collection::where('id', $collectionItem[$item['collection_item_id']]->collection_id)->pluck('user_id')->first();
                $wallet_address[$item['collection_item_id']] = SellerProfile::where("user_id", $seller[$item['collection_item_id']])->pluck('wallet_address')->first();
            }
            foreach ($items as $item) {
                if ($collectionItem[$item['collection_item_id']]->available_for_sale == 1 || ($collectionItem[$item['collection_item_id']]->available_for_sale == 2 &&
                ($collectionItem[$item['collection_item_id']]->lastBet()->exists() && $collectionItem[$item['collection_item_id']]->lastBet->buyer_id == auth()->user()->id))) {
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
                    $grandTotal += $total;
                    if ($collectionItem[$item['collection_item_id']]->available_for_sale == 2) {
                            $item['auction_id'] = $collectionItem[$item['collection_item_id']]->lastBet->id;
                    } else {
                        $item['auction_id'] = null;
                    }
                    
                    $result[] = $this->orderCollectionRepository->create($order, $item);

                } else {
                    throw new ErrorException("Collection id not for sale or not for auction.");
                }
            }
            DB::commit();
            $response = $this->paymentGateService->transaction((string) $grandTotal, $data['currency'], $data['secretKey']);
            $emailData['item'] = $collectionItem;
            $emailData['order'] = $order;
            if ($response) {
                foreach ($items as $item) {
                    $item['transaction_type'] = OrderTransaction::DEBIT;
                    $item['currency'] = $data['currency'];
                    $this->orderRepository->update($order);
                    $this->orderTransactionRepository->success($order, $item, $response);
                    Event::dispatch('orders.success', [$emailData]);
                }
            } else {
                foreach ($items as $item) {
                    $item['transaction_type'] = OrderTransaction::DEBIT;
                    $item['currency'] = $data['currency'];
                    $this->orderTransactionRepository->failed($order, $item, $response);
                    Event::dispatch('orders.failed', [$emailData]);
                }
            }
        } catch (ErrorException $e) {
            DB::rollback();
            return false;
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
        $result = $this->orderRepository->getall();
        return $this->paymentGateService->paginate($result);
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

    public function todo()
    {
        // if ($response) {
        //     $result['reservation'] = $response;
        //     return $result;
        // } else {
        //     throw new ErrorException("Reversation id doesnt exist.");
        // }
    }
}
