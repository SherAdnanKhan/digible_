<?php
namespace App\Http\Services\Auctions;

use Exception;
use App\Models\User;
use App\Models\Auction;
use App\Models\CollectionItem;
use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Log;
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
        try {
            $collectionItem = CollectionItem::find($data['collection_item_id']);
            if (isset($collectionItem)) {
                if ($data['last_price'] < $collectionItem->price || $collectionItem->available_for_sale !=2 
                || !isset($collectionItem->collection->user_id)) {
                    return false;
                }
            }

            $Auction = Auction::where(['collection_item_id' => $data['collection_item_id'], "status" => Auction::STATUS_PENDING])->latest('created_at')->first();
            if (isset($Auction)) {
                if ($data['last_price'] <= $Auction->last_price) {
                    return false;
                }
            }
            $data['status'] = Auction::STATUS_PENDING;
            $data['seller_id'] = $collectionItem->collection->user_id;
            $data['buyer_id'] = auth()->user()->id;
            $data['base_price'] = $collectionItem->price;
            Log::info(__METHOD__ . " -- New Auction request info: ", $data);
            $this->repository->save($data);
            return true;
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }
}
