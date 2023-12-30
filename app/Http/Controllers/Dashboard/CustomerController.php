<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Sale;
use App\Notifications\CustomerAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as NotificationModel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data  = User::orderBy('id','ASC')->where('roles_name', null)
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->when($request->email != null,function ($q) use($request){
            return $q->where('email','like','%'.$request->email.'%');
        })
        ->when($request->mobile != null,function ($q) use($request){
            return $q->where('mobile','like','%'.$request->mobile.'%');
        })
        ->paginate(config('myConfig.paginationCount'));
        
        return view('dashboard.customer.index')
        ->with([
            'data'   => $data,
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => $request->mobile,
        ]);
    }
    


    public function show($id)
    {
        $data = User::with(['customer.sales.sale_details'])->find($id);
        return view('dashboard.customer.show',compact('data'));
    }
    


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name'       => 'required',
                'email'      => 'required|email|unique:users,email',
                'mobile'     => 'required|unique:users,mobile',
                'password'   => 'required|same:confirm-password',
                'status'     => 'required',
            ]);
            if($validator->fails())
            {
                session()->flash('error');
                return redirect()->back();
            }
            $customer = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'mobile'   => $request->mobile,
                'password' => bcrypt($request->password),
                'status'   => $request->status,
            ]);

            $user = Customer::create(['user_id' => $customer->id]);

            if (!$customer) {
                session()->flash('error');
                return redirect()->back();
            }

            //send notification mail
            $customers = User::where('id', '!=', Auth::user()->id)->get();
            // $id   = User::latest()->first()->id;
            Notification::send($customers, new CustomerAdded($customer->id));

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

        
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name'     => 'required',
                'email'    => 'required|email|unique:users,email,'.$request->id,
                'mobile'   => 'required|unique:users,mobile,'.$request->id,
            ]);
            if($validator->fails())
            {
                session()->flash('error');
                return redirect()->back();
            }
            $inputs = $request->all();
            // if(!empty($input['password'])) {
            //     $input['password'] = Hash::make($input['password']);
            // } else {
            //     $input = array_except($input,array('password'));
            // }
            $customer = User::find($request->id);
            $customer->update($inputs);

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    


    public function destroy(Request $request)
    {
        try {
            // $related_table = realed_model::where('user_id', $request->id)->pluck('user_id');
            // if($related_table->count() == 0) { 
                $customer = User::findOrFail($request->id);
                if (!$customer) {
                    session()->flash('error');
                    return redirect()->back();
                }
                $customer->delete();
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



    public function showNotification($id)
    {
        $notification = NotificationModel::findOrFail($id);
        $notification->update([
            'read_at' => now(),
        ]);
        $customer = User::findOrFail($id);
        return view('dashboard.customers.show',compact('customer'));
    }
    


    public function changeStatus($id)
    {
        try {
            $user = User::find($id);
            if($user->status == 0)
            {
                $user->update(['status' => 1]);
            }
            else
            {
                $user->update(['status' => 0]);
            }
            if(!$user)
            {
                session()->flash('error');
                return redirect()->back();
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
