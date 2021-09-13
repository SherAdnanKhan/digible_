<?php
namespace App\Http\Services\Sellers;

use App\Http\Repositories\Sellers\SellerRequestRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class SellerRequestService extends BaseService
{
    protected $repository;

    public function __construct(SellerRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Seller data all fetched: ");
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        Log::info(__METHOD__ . " -- Seller data fetched ");
        return $this->repository->getById($id);
    }

    public function saveSeller(array $data): void
    {
        Log::info(__METHOD__ . " -- New Seller request info: ", $data);
        $this->repository->save($data);
    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            Log::info(__METHOD__ . " -- Seller data deleted ");
            $Seller = $this->repository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete Seller data');
        }

        DB::commit();
        return $Seller;
    }

    public function updateSellerRequest($data, $id)
    {
        DB::beginTransaction();
        try {
            $Seller = $this->repository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException($e);
        }

        DB::commit();
        return $Seller;
    }
}
