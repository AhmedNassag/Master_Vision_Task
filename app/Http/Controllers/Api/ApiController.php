<?php

namespace App\Http\Controllers\Api;


use App\Models\Sale;
use App\Models\Product;
use App\Models\ShopProduct;
use App\Models\Sale_Detail;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ApiResponseTrait;

    public function latestShopProducts(Request $request)
    {
        try {
            $latestShopProducts = ShopProduct::with(['shop', 'product'])
            ->when($request->category_id != null,function ($q) use($request){
                $q->whereRelation('product','category_id',$request->category_id);
            })
            ->paginate(config('myconfig.pagination_count'));

            if(!$latestShopProducts)
            {
                return $this->apiResponse(null,'No Data Founded',404);
            }
            return $this->apiResponse($latestShopProducts,'Data Returned Successfully',200);

        } catch (\Exception $e) {
            return $this->sendError('An error occurred in the system');
        }
    }



    public function shopProductsUnderCategoryOrChild(Request $request)
    {
        try {
            $shopProductsUnderCategoryOrChild = ShopProduct::with(['shop', 'product'])
            ->when($request->category_id != null,function ($q) use($request){
                $q->whereRelation('product','category_id',$request->category_id);
                $q->orWhereRelation('product.category.category','id',$request->category_id);
            })
            ->paginate(config('myconfig.pagination_count'));

            if(!$shopProductsUnderCategoryOrChild)
            {
                return $this->apiResponse(null,'No Data Founded',404);
            }
            return $this->apiResponse($shopProductsUnderCategoryOrChild,'Data Returned Successfully',200);
        
        } catch (\Exception $e) {
            return $this->apiResponse(null,'An Error Occurred In The System',400);
        }
    }



    public function addOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator  = Validator::make($request->all(),
            [
                'date'                 => 'required',
                'customer_id'          => 'required',
                'details.*.shop_id'    => 'required',
                'details.*.product_id' => 'required',
                'details.*.quantity'   => 'required',
            ]);
            if ($validator->fails())
            {
                return $this->apiResponse(null,$validator->errors(),400);
            }

            $sale = Sale::create([
                'date'        => $request->date,
                'customer_id' => $request->customer_id,
                'notes'       => $request->notes,
                'discount'    => 0,
                'tax'         => 0,
            ]);
            $grandTotal = 0;
            foreach($request->details as $detail)
            {
                //check if quantity available
                $shopProduct = ShopProduct::where('shop_id', $detail['shop_id'])->where('product_id', $detail['product_id'])->where('quantity', '>=', $detail['quantity'])->first();
                if (!$shopProduct) {
                    return $this->apiResponse(null,'This Quantity Not Available Now',400);
                }

                $product     = Product::findOrFail($detail['product_id']);
                $saleDetails = Sale_Detail::create([
                    'quantity'   => $detail['quantity'],
                    'unit_price' => $product->price,
                    'shop_id'    => $detail['shop_id'],
                    'product_id' => $detail['product_id'],
                    'sale_id'    => $sale->id,
                ]);
                //calculate the total price from product price
                $grandTotal = $grandTotal + ($saleDetails->unit_price * $saleDetails->quantity);

                //update and decrease the shop product quantity
                $shopProductQuantity = ShopProduct::where('shop_id', $detail['shop_id'])->where('product_id', $detail['product_id'])->first();
                $shopProductQuantity->update(['quantity' => $shopProductQuantity->quantity - $detail['quantity']]);
            
            }
            $sale->update(['grandTotal' => $grandTotal]);

            if(!$sale)
            {
                return $this->apiResponse(null,'Order Not Completed Successfully',400);
            }

            DB::commit();
            return $this->apiResponse($sale,'Order Completed Successfully',201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(null,'An Error Occurred In The System',400);
        }
    }
}
