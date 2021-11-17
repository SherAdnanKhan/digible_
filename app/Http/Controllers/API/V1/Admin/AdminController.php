<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Http\Services\Admins\AdminService;
use App\Http\Transformers\Admins\AdminTransformer;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * @var AuthService
     */
    private $service;

    /**
     * @var AdminTransformer
     */
    private $transformer;

    public function __construct(
        AdminService $service,
        AdminTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAll();
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
    public function store(StoreRequest $request)
    {
        $this->service->register($request->validated());

        return $this->success([], null, trans('messages.admin_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->where('id',$id)->first();
        return $this->success($user, $this->transformer);
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
    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        $this->service->update($request->validated(), $user);
        return $this->success($user, $this->transformer, trans('messages.update_admin_account'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return $this->success([], null, trans('messages.admin_delete_success'));
        }
        return $this->success([], null, trans('messages.admin_doesnot_exist'));
    }
}
