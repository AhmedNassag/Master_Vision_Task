<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Product\ProductInterface;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Http\Requests\Dashboard\Product\UpdateRequest;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }



    public function index(Request $request)
    {
        return $this->product->index($request);
    }



    public function show($id)
    {
        return $this->product->show($id);
    }



    public function store(StoreRequest $request)
    {
        return $this->product->store($request);
    }



    public function update(UpdateRequest $request)
    {
        return $this->product->update($request);
    }



    public function destroy(Request $request)
    {
        return $this->product->destroy($request);
    }



    public function deleteSelected(Request $request)
    {
        return $this->product->deleteSelected($request);
    }



    public function showNotification($route_id,$notification_id)
    {
        return $this->product->showNotification($route_id,$notification_id);
    }



    public function details($id)
    {
        $details  = DB::table('products')->where('id', $id)->select('price', 'id')->get();
        return response()->json($details);
    }
}