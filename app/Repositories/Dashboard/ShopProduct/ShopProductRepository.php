<?php

namespace App\Repositories\Dashboard\ShopProduct;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ShopProduct;
use App\Notifications\ShopAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class ShopProductRepository implements ShopProductInterface 
{

    public function index($request)
    {
        $shopProducts = ShopProduct::where('shop_id',null)->get();
        foreach($shopProducts as $shopProduct)
        {
            $shopProduct->delete();
        }


        $data = ShopProduct::with(['shop', 'product'])
        ->when($request->shop_id != null,function ($q) use($request){
            return $q->where('shop_id','like', '%'.$request->shop_id.'%');
        })
        ->when($request->product_id != null,function ($q) use($request){
            return $q->where('product_id','like', '%'.$request->product_id.'%');
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->paginate(config('myConfig.paginationCount'));

        $shops    = Shop::get(['id','name']);
        $products = Product::get(['id','name']);

        return view('dashboard.shopProduct.index',compact('data', 'shops', 'products'))
        ->with([
            'shop_id'    => $request->shop_id,
            'product_id' => $request->product_id,
            'from_date'  => $request->from_date,
            'to_date'    => $request->to_date,
        ]);
    }



    public function show($id)
    {
        $data = ShopProduct::findOrFail($id);
        return view('dashboard.shopProduct.show', compact('data'));
    }



    public function create()
    {
        $shopProducts = ShopProduct::where('shop_id',null)->get();
        foreach($shopProducts as $shopProduct)
        {
            $detail->delete();
        }
        return view('dashboard.shopProduct.create');
    }



    public function store($request)
    {
        try {
            $validated = $request->validated();
            // $inputs    = $request->all();
            // //insert data
            // $shop = ShopProduct::create($inputs);
            $shopProducts = ShopProduct::where('shop_id',null)->get();
            foreach($shopProducts as $shopProduct)
            {
                $oldShopProduct = ShopProduct::where('shop_id',$request->shop_id)->where('product_id',$shopProduct->product_id)->first();
                if($oldShopProduct)
                {
                    //هنا يجب زيادة العدد القديم وليس إنشاء قيمة جديدة
                    $oldShopProduct->update(['quantity' => $oldShopProduct->quantity + $shopProduct->quantity]);
                }
                else
                {
                    $shopProduct->update(['shop_id' => $request->shop_id]);
                }
            }
            if (!$shopProduct) {
                session()->flash('error');
                return redirect()->back();
            }

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update($request)
    {
        try {
            $validated   = $request->validated();
            $inputs      = $request->all();
            $shopProduct = ShopProduct::findOrFail($request->id);
            //check if there is an old record in database
            if($shopProduct->shop_id != $request->shop_id || $shopProduct->product_id != $request->product_id) {
                $oldShopProduct = ShopProduct::where('shop_id',$request->shop_id)->where('product_id',$request->product_id)->first();
                if($oldShopProduct)
                {
                    session()->flash('canNotUpdated');
                    return redirect()->back();
                }
            }
            if (!$shopProduct) {
                session()->flash('error');
                return redirect()->back();
            }
            $shopProduct->update($inputs);
            if (!$shopProduct) {
                session()->flash('error');
                return redirect()->back();
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy($request)
    {
        try {
            // $related_table = realed_model::where('shop_id', $request->id)->pluck('shop_id');
            // if($related_table->count() == 0) { 
                $shopProduct = ShopProduct::findOrFail($request->id);
                if (!$shopProduct) {
                    session()->flash('error');
                    return redirect()->back();
                }
                $shop->delete();
                session()->flash('success');
                return redirect()->back();
            // } else {
                // session()->flash('canNotDeleted');
                // return redirect()->back();
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function deleteSelected($request)
    {
        try {
            $delete_selected_id = explode(",", $request->delete_selected_id);
            // foreach($delete_selected_id as $selected_id) {
            //     $related_table = realed_model::where('shop_id', $selected_id)->pluck('shop_id');
            //     if($related_table->count() == 0) {
                    $shopProducts = ShopProduct::whereIn('id', $delete_selected_id)->delete();
                    session()->flash('success');
                    return redirect()->back();
            //     } else {
            //         session()->flash('canNotDeleted');
            //         return redirect()->back();
            //     }
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function showNotification($id,$notification_id)
    {
        $shopProducts = ShopProduct::where('shop_id',null)->get();
        foreach($shopProducts as $shopProduct)
        {
            $shopProduct->delete();
        }

        $notification = NotificationModel::findOrFail($notification_id);
        $notification->update([
            'read_at' => now(),
        ]);

        return $this->show($id);
    }

}
