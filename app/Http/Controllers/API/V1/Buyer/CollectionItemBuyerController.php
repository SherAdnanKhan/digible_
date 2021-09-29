<?php

namespace App\Http\Controllers\API\V1\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Services\Collections\CollectionItemService;

class CollectionItemBuyerController extends Controller
{
    protected $service;

    public function __construct(CollectionItemService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // afs mean available for sale
    public function index()
    {
        return $this->service->afsAll();
    }
}
