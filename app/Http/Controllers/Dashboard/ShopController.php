<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Shop\ShopInterface;
use App\Http\Requests\Dashboard\Shop\StoreRequest;
use App\Http\Requests\Dashboard\Shop\UpdateRequest;

class ShopController extends Controller
{
    protected $shop;

    public function __construct(ShopInterface $shop)
    {
        $this->shop = $shop;
    }



    public function index(Request $request)
    {
        return $this->shop->index($request);
    }



    public function show($id)
    {
        return $this->shop->show($id);
    }



    public function store(StoreRequest $request)
    {
        return $this->shop->store($request);
    }



    public function update(UpdateRequest $request)
    {
        return $this->shop->update($request);
    }



    public function destroy(Request $request)
    {
        return $this->shop->destroy($request);
    }



    public function deleteSelected(Request $request)
    {
        return $this->shop->deleteSelected($request);
    }



    public function showNotification($route_id,$notification_id)
    {
        return $this->shop->showNotification($route_id,$notification_id);
    }
}
