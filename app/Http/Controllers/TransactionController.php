<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller{

    public function viewProductPostBuy(Request $request)
    {
        $item = Item::with(['user', 'item_images', 'shippingDetail'])->where('id', $request->item_id)->first();
        
    }

}
