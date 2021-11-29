<?php
namespace App\Http\Services\Auctions;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Auctions\AuctionRepository;
use App\Http\Services\BaseService;
use App\Models\Auction;
use App\Models\CollectionItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AuctionService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(AuctionRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getByUser()
    {
        Log::info(__METHOD__ . " -- Get User Bets by Collection Item: ");
        $result = $this->repository->getByUser();
        return $this->service->paginate($result);
    }

    public function getWonBets()
    {
        Log::info(__METHOD__ . " -- Get User Won Bets: ");
        $result = $this->repository->getWonBets();
        return $this->service->paginate($result);
    }

    public function save(array $data)
    {

        $collectionItem = CollectionItem::find($data['collection_item_id']);
        if (isset($collectionItem)) {
            if ($data['last_price'] < $collectionItem->price || $collectionItem->available_for_sale != 2
                || !isset($collectionItem->collection->user_id) || $collectionItem->status == CollectionItem::STATUS_PENDING) {
                throw new ErrorException('exception.auction_failed', [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $last_bet = Auction::where(['collection_item_id' => $data['collection_item_id'], "status" => Auction::STATUS_PENDING])->latest('created_at')->first();
        if (isset($last_bet)) {
            if ($data['last_price'] <= $last_bet->last_price) {
                throw new ErrorException('exception.price_increased', ["last_bet" => $last_bet], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        try {
            $data['status'] = Auction::STATUS_PENDING;
            $data['seller_id'] = $collectionItem->collection->user_id;
            $data['buyer_id'] = auth()->user()->id;
            $data['base_price'] = $collectionItem->price;
            Log::info(__METHOD__ . " -- New Auction request info: ", $data);
            $result = $this->repository->save($data);
            if (isset($last_bet)) {
                $emailData['item'] = $collectionItem;
                $emailData['user_id'] = $last_bet->buyer_id;
                Event::dispatch('auction.higher_bet', [$emailData]);
            }
            return $result;
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }
}
