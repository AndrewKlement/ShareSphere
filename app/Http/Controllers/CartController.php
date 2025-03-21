<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Item;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller{
    
    public function viewCart()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $carts = CartDetail::with(['item' => function ($query) {
            $query->withTrashed(); // Include soft-deleted items
        }, 'item.item_images' => function ($query) {
            $query->where('img_position', 1)
                  ->orWhereNotIn('id', function ($subquery) {
                      $subquery->select('id')
                               ->from('item_images')
                               ->where('img_position', 1);
                  })
                  ->orderBy('img_position', 'asc')
                  ->orderBy('created_at', 'asc');
        }
        ])->where('user_id', $userId)->get();

        $groupedCarts = $carts->groupBy('item.user_id');

        return view('cart', compact('groupedCarts'));
    }

    public function viewProductPostCart(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $request->validate([
            "quantity" => "required",
        ]);

        $item = Item::where('id', $request->item_id)->first();

        $cart_detail = CartDetail::where('user_id', $userId)
        ->where('item_id', $item->id)
        ->first();

        if ($cart_detail) {
            $newQuantity = $cart_detail->quantity + $request->quantity;
    
            if ($newQuantity > $item->stock) {
                return redirect()->back()->with("error", "Failed to add because item out off stock");
            }

            $cart_detail->quantity = $newQuantity;
            $cart_detail->total_price = $newQuantity * $item->price;
        } else {
            if ($request->quantity > $item->stock) {
                return redirect()->back()->with("error", "Failed to add because item out off stock");
            }
    
            $cart_detail = new CartDetail();
            $cart_detail->fill([
                'user_id' => $userId,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $item->price
            ]);
        }
        
        if(!$cart_detail->save()){
            return redirect()->back()->with("error", "Failed to add item");
        }

        return redirect(route("cart"))->with("success", "Item added to Cart");;
    }

    public function processPurchase(Request $request) {
        if (!$request->filled('selected_items') || empty($request->selected_items)) {
            return redirect()->route('cart');
        }

        $selectedItems = explode(',', $request->selected_items);
    
        $carts = CartDetail::with(['item', 'item.item_images' => function ($query) {
            $query->where('img_position', 1)
                    ->orWhereNotIn('id', function ($subquery) {
                        $subquery->select('id')
                                ->from('item_images')
                                ->where('img_position', 1);
                    })
                    ->orderBy('img_position', 'asc')
                    ->orderBy('created_at', 'asc');
        }
        ])->whereIn('id', $selectedItems)->get();

        $groupedCarts = $carts->groupBy('item.user_id');

        return view('cartcheckout', compact('groupedCarts'));
    }

    public function processPayment(Request $request) {
        
    }
    
    public function delete($id) {
        CartDetail::findOrFail($id)->delete();
        return back()->with('success', 'Item removed from cart');
    }
    
    public function update(Request $request, $id) {
        $cart = CartDetail::findOrFail($id);
        $item = Item::where('id', $cart->item_id)->first();

        if ($request->quantity <= $item->stock) {
            $cart->quantity = $request->quantity;
            $cart->total_price = $request->quantity * $item->price;
    
            $cart->save();
    
            return response()->json([
                'success' => true,
                'newPrice' => $cart->total_price,
                'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
            ]);
        }else{
            return response()->json([
                'success' => false,
                'newPrice' => $cart->total_price,
                'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
            ]);
        }
    }
}
