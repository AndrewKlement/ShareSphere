<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingDetail;


class IndexController extends Controller{


    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
    
        $userId = Auth::id();
        
        $shippingdetail = ShippingDetail::where('user_id', $userId)->first() ?? null;
        
        if ($shippingdetail) {
            $items = Item::with(['user', 'item_images' => function ($query) {
            $query->where('img_position', 1)
                ->orWhere(function ($q) {
                    $q->whereNotIn('id', function ($subquery) {
                        $subquery->select('id')->from('item_images')->where('img_position', 1);
                    });
                })
                ->orderBy('img_position', 'asc')
                ->orderBy('created_at', 'asc')
                ->limit(1);
            }])->with('shippingDetail')->where('stock', '!=', 0)->get();

            return view("index", compact('items'));
        }
        return view("shippingdetail", compact('shippingdetail'));
    }

    public function indexSearch(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $userId = Auth::id();
        $shippingdetail = ShippingDetail::where('user_id', $userId)->first() ?? null;

        if (!$shippingdetail) {
            return view("shippingdetail", compact('shippingdetail'));
        }

        $query = Item::with(['user', 'item_images' => function ($query) {
            $query->where('img_position', 1)
                ->orWhere(function ($q) {
                    $q->whereNotIn('id', function ($subquery) {
                        $subquery->select('id')->from('item_images')->where('img_position', 1);
                    });
                })
                ->orderBy('img_position', 'asc')
                ->orderBy('created_at', 'asc')
                ->limit(1);
        }])->with('shippingDetail')->where('stock', '!=', 0);

        if ($request->has('query') && !empty($request->query('query'))) {
            $searchTerm = $request->query('query');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $items = $query->get();

        return view("index", compact('items'));
    }
}
