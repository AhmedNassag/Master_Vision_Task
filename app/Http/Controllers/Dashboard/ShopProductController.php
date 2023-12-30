<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\ShopProduct\ShopProductInterface;
use App\Http\Requests\Dashboard\ShopProduct\StoreRequest;
use App\Http\Requests\Dashboard\ShopProduct\UpdateRequest;

class ShopProductController extends Controller
{
    protected $shopProduct;

    public function __construct(ShopProductInterface $shopProduct)
    {
        $this->shopProduct = $shopProduct;
    }



    public function index(Request $request)
    {
        return $this->shopProduct->index($request);
    }



    public function show($id)
    {
        return $this->shopProduct->show($id);
    }



    public function create()
    {
        return $this->shopProduct->create();
    }



    public function store(StoreRequest $request)
    {
        return $this->shopProduct->store($request);
    }



    public function update(UpdateRequest $request)
    {
        return $this->shopProduct->update($request);
    }



    public function destroy(Request $request)
    {
        return $this->shopProduct->destroy($request);
    }



    public function deleteSelected(Request $request)
    {
        return $this->shopProduct->deleteSelected($request);
    }



    public function showNotification($route_id,$notification_id)
    {
        return $this->shopProduct->showNotification($route_id,$notification_id);
    }





    public function fetchDetails()
    {
        $sale_details = [];
        $sales_details = ShopProduct::where('shop_id',null)->get();
        foreach($sales_details as $sale_detail)
        {            
            $item['id']       = $sale_detail->id;
            $item['quantity'] = $sale_detail->quantity;
            $item['product']  = $sale_detail->product->name;
            $sale_details[]   = $item;
        }
        return response()->json([
            'sale_details' => $sale_details,
        ]);
    }



    public function storeDetails(Request $request)
    {
        try {
            //insert data
            $detail = ShopProduct::create([
                'quantity'   => $request->quantity,
                'product_id' => $request->product_id,
            ]);
            if (!$detail) {
                return response()->json([
                    'status'   => false,
                    'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                ]);
            }
            return response()->json([
                'status'   => true,
                'messages' => 'تم الحفظ بنجاح',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroyDetails($id)
    {
        $detail = ShopProduct::find($id);
        $detail->delete();
        return response()->json([
            'status'   => true,
            'messages' => 'تم الحفظ بنجاح',
        ]);
    }



    public function shopProductsQuantity($id)
    {
        $products = [];
        $shopProducts = DB::table('shop_products')->where('shop_id', $id)->where('quantity','>',0)->get();
        foreach($shopProducts as $shopProduct)
        {
            $product      = DB::table('products')->where('id', $shopProduct->product_id)->first();
            $item['id']   = $product->id;
            $item['name'] = $product->name;
            $products[]   = $item;
        }
        return response()->json($products);
    }
}
