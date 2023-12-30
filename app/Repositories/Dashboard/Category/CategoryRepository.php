<?php

namespace App\Repositories\Dashboard\Category;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CategoryAdded;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class CategoryRepository implements CategoryInterface 
{

    public function index($request)
    {
        $data = Category::with(['category'])
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like', '%'.$request->name.'%');
        })
        ->when($request->parent_id != null,function ($q) use($request){
            return $q->where('parent_id', $request->parent_id);
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->paginate(config('myConfig.paginationCount'));

        $categories = Category::get(['id','name']);

        return view('dashboard.category.index',compact('data', 'categories'))
        ->with([
            'name'      => $request->name,
            'parent_id' => $request->parent_id,
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
        ]);
    }



    public function show($id)
    {
        $data = Category::with(['category','products'])->findOrFail($id);
        return view('dashboard.category.show', compact('data'));
    }



    public function store($request)
    {
        try {
            $validated = $request->validated();
            $inputs    = $request->all();
            //insert data
            $category = Category::create($inputs);
            if (!$category) {
                session()->flash('error');
                return redirect()->back();
            }
            //send notification
            $users = User::/*where('id', '!=', Auth::user()->id)->*/get();
            Notification::send($users, new CategoryAdded($category->id));

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
            $category = Category::findOrFail($request->id);
            if (!$category) {
                session()->flash('error');
                return redirect()->back();
            }
            $category->update($inputs);
            if (!$category) {
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
            // $related_table = realed_model::where('category_id', $request->id)->pluck('category_id');
            // if($related_table->count() == 0) { 
                $category = Category::findOrFail($request->id);
                if (!$category) {
                    session()->flash('error');
                    return redirect()->back();
                }
                $category->delete();
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
            //     $related_table = realed_model::where('category_id', $selected_id)->pluck('category_id');
            //     if($related_table->count() == 0) {
                    $categories = Category::whereIn('id', $delete_selected_id)->delete();
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
