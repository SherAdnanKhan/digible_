<?php
namespace App\Http\Services\Auctions;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Response;
use App\Models\CollectionItem;
use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Http\Repositories\Auctions\AuctionRepository;

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
                || !isset($collectionItem->collection->user_id)) {
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
            if (isset($last_bet) && $last_bet->buyer_id != Auth::user()->id) {
                $emailData['item'] = $collectionItem;
                $emailData['user_id'] = $last_bet->buyer_id;
                Event::dispatch('auction.higher_bet', [$emailData]);
            }
            return $result;
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function updateWonAuction(array $data)
    {
        Log::info(__METHOD__ . " -- Get User Won Bets: ");
        try {
            if (isset($data['collection_item_id'])) {
                $auction = Auction::where(['collection_item_id' => $data['collection_item_id'], 'status' => Auction::STATUS_WON])->first();
                if ($auction) {
                    throw new ErrorException('exception.auction_failed', [], Response::HTTP_UNPROCESSABLE_ENTITY);
                } else {
                    $collectionItem = CollectionItem::find($data['collection_item_id']);
                    if ($this->service->dateComparision($collectionItem->start_date, Carbon::now()->toDateTimeString(), 'lt') &&
                        $this->service->dateComparision($collectionItem->end_date, Carbon::now(), 'lt')) {
                        return $this->repository->updateWonAuction($data);
                    } else {
                        throw new ErrorException('exception.auction_failed', [], Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                }
            }
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }
}
