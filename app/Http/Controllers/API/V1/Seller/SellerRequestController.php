<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Sellers\SellerCreateRequest;
use App\Http\Requests\Sellers\SellerUpdateRequest;
use App\Http\Services\Sellers\SellerRequestService;

class SellerRequestController extends Controller
{
    protected $service;

    public function __construct(SellerRequestService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->service->getAll();
            if (count($result) == 0) {
                return $this->success([], null, trans('messages.general_empty_data'));
            }
        } catch (Exception $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success($result);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerCreateRequest $request)
    {
        $seller = Seller::where('user_id', Auth::user()->id)->first();
        if ($seller) {
            return $this->failure([], trans('messages.seller_request_exist'));
        }
        $data = $request->all();
        try {
            $this->service->saveSeller($data);
        } catch (Execption $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success([], null, trans('messages.seller_request_create_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerUpdateRequest $request, $id)
    {
        $data = $request->all();
        try {
            $result = $this->service->updateSellerRequest($data, $id);
        } catch (Exception $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success([$result], null, trans('messages.seller_request_update_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->service->deleteById($id);
        } catch (Exception $e) {
            return $this->failure([], null, trans('messages.general_error'));
        }

        return $this->success([], null, trans('messages.seller_request_delete_success'));
    }
}
