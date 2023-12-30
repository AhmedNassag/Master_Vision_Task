<?php

namespace App\Repositories\Dashboard\Shop;

use App\Models\User;
use App\Models\Shop;
use App\Notifications\ShopAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class ShopRepository implements ShopInterface 
{

    public function index($request)
    {
        $data = Shop::
        when($request->name != null,function ($q) use($request){
            return $q->where('name','like', '%'.$request->name.'%');
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->paginate(config('myConfig.paginationCount'));

        return view('dashboard.shop.index',compact('data'))
        ->with([
            'name'      => $request->name,
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
        ]);
    }



    public function show($id)
    {
        $data = Shop::with(['shopProducts.product'])->findOrFail($id);
        return view('dashboard.shop.show', compact('data'));
    }



    public function store($request)
    {
        try {
            $validated = $request->validated();
            $inputs    = $request->all();
            //insert data
            $shop = Shop::create($inputs);
            if (!$shop) {
                session()->flash('error');
                return redirect()->back();
            }
            //send notification
            $users = User::/*where('id', '!=', Auth::user()->id)->*/get();
            Notification::send($users, new ShopAdded($shop->id));

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function update($request)
    {
        try {
            $validated = $request->validated();
            $inputs    = $request->all();
            $shop      = Shop::findOrFail($request->id);
            if (!$shop) {
                session()->flash('error');
                return redirect()->back();
            }
            $shop->update($inputs);
            if (!$shop) {
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
                $shop = Shop::findOrFail($request->id);
                if (!$shop) {
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
                    $shops = Shop::whereIn('id', $delete_selected_id)->delete();
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
        $notification = NotificationModel::findOrFail($notification_id);
        $notification->update([
            'read_at' => now(),
        ]);

        return $this->show($id);
    }

}
