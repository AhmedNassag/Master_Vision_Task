<?php

namespace App\Repositories\Dashboard\Product;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ImageTrait;
use App\Notifications\ProductAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class ProductRepository implements ProductInterface 
{
    use ImageTrait;

    public function index($request)
    {
        $data = Product::with(['media', 'category'])
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like', '%'.$request->name.'%');
        })
        ->when($request->price != null,function ($q) use($request){
            return $q->where('price','like', '%'.$request->price.'%');
        })
        ->when($request->category_id != null,function ($q) use($request){
            return $q->where('category_id', $request->category_id);
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->paginate(config('myConfig.paginationCount'));

        $categories = Category::get(['id','name']);

        return view('dashboard.product.index',compact('data', 'categories'))
        ->with([
            'name'        => $request->name,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
        ]);
    }



    public function show($id)
    {
        $data = Product::with(['media', 'category', 'shopProducts.shop'])->findOrFail($id);
        return view('dashboard.product.show', compact('data'));
    }



    public function store($request)
    {
        try {
            $validated = $request->validated();
            //insert data
            $product = Product::create([
                'name'        => $request->name,
                'price'       => $request->price,
                'category_id' => $request->category_id,
            ]);
            //upload file
            if ($request->file) {
                $this->uploadMedia($product, 'product', $request->file);
            }
            if (!$product) {
                session()->flash('error');
                return redirect()->back();
            }
            //send notification
            $users = User::/*where('id', '!=', Auth::user()->id)->*/get();
            Notification::send($users, new ProductAdded($product->id));

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
            $product   = Product::findOrFail($request->id);
            if (!$product) {
                session()->flash('error');
                return redirect()->back();
            }
            $product->update([
                'name'        => $request->name,
                'price'       => $request->price,
                'category_id' => $request->category_id,
            ]);
            //upload file
            if ($request->file) {
                $this->uploadMedia($product, 'product', $request->file);
            }
            if (!$product) {
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
            // $related_table = realed_model::where('product_id', $request->id)->pluck('product_id');
            // if($related_table->count() == 0) { 
                $product = Product::findOrFail($request->id);
                if (!$product) {
                    session()->flash('error');
                    return redirect()->back();
                }
                $product->delete();
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
            //     $related_table = realed_model::where('product_id', $selected_id)->pluck('product_id');
            //     if($related_table->count() == 0) {
                    $products = Product::whereIn('id', $delete_selected_id)->delete();
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
