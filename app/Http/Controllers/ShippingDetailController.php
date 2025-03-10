<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\ShippingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShippingDetailController extends Controller{


    public function shippingDetail()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
    
        $userId = Auth::id();

        $shippingdetail = ShippingDetail::where('user_id', $userId)->first() ?? null;
        
        return view("shippingdetail", compact('shippingdetail'));
    }

    public function shippingDetailPost(Request $request)
    {
        $request->validate([
            "phone"=>"required",
            "selectProvince"=>"required",
            "postcode"=>"required",
            "address"=>"required"
        ]);

        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $shippingdetail = ShippingDetail::where('user_id', $userId)->first();
        
        if($shippingdetail){
            $shippingdetail->phone_number = $request->phone;
            $shippingdetail->province = $request->selectProvince;
            $shippingdetail->postal_code = $request->postcode;
            $shippingdetail->address = $request->address;

            if(!$shippingdetail->save()){
                return redirect(route("shippingDetail"))
                ->with("error", "Failed to add shipping detail");
            }
            return redirect(route("home"))->with("success", "Shipping detail modified");;
        }
        else{
            $shippingdetail = new ShippingDetail;
            $shippingdetail->fill([
                'phone_number' => $request->phone,
                'province' => $request->selectProvince,
                'city' => 'Jakarta',
                'postal_code' => $request->postcode,
                'address' => $request->address,
                'user_id' => $userId
            ]);
            
                    
            if(!$shippingdetail->save()){
                return redirect(route("shippingDetail"))
                ->with("error", "Failed to add shipping detail");
            }
            return redirect(route("home"))->with("success", "Shipping detail added");;
        }

    }
}
