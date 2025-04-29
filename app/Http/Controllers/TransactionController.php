<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller{

    public function viewTransaction()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $trans = TransactionHeader::with(['transactionDetail.item' => function ($query) {
            $query->withTrashed();
        }, 'transactionDetail.item.item_images' => function ($query) {
            $query->where('img_position', 1)
                  ->orWhereNotIn('id', function ($subquery) {
                      $subquery->select('id')
                               ->from('item_images')
                               ->where('img_position', 1);
                  })
                  ->orderBy('img_position', 'asc')
                  ->orderBy('created_at', 'asc');
        }
        ])->where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('transaction', compact('trans'));
    }
}
