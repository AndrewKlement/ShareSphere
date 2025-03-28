<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Item;
use App\Models\CartDetail;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
            "duration" => "required",
        ]);

        $item = Item::where('id', $request->item_id)->first();

        $totStock = CartDetail::where('user_id', auth()->id())->where('item_id', $request->item_id)->sum('quantity');

        $newTotalQuantity = $totStock + $request->quantity; 

        if ($newTotalQuantity > $item->stock) {
                return redirect()->back()->with("error", "Failed to add because item out off stock");
        }

        $cart_detail = new CartDetail();
        $cart_detail->fill([
            'user_id' => $userId,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'duration' => $request->duration,
            'total_price' => $request->quantity * $item->price *$request->duration
        ]);
        
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
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $selectedItems = collect(json_decode($request->selected_items, true))
        ->map(fn($id) => (int) $id)
        ->toArray();

        $carts = CartDetail::whereIn('id', $selectedItems)->get();
        
        if (!empty($selectedItems)) {
            DB::beginTransaction();
    
            try {
                $transHead = new TransactionHeader();
                $transHead->user_id = $userId;
    
                if(!$transHead->save()){
                    throw new \Exception("Payment failed");
                }
    
                $saveHeadId = $transHead->id;
                
                foreach($carts as $cart){
                    $transD = new TransactionDetail();
                    $transD->fill([
                        'transaction_header_id' => $saveHeadId,
                        'item_id' => $cart->item_id,
                        'quantity' => $cart->quantity,
                        'quantity_return' => 0,
                        'duration' => $cart->duration,
                        'total_price' => $cart->total_price,
                    ]);

                    $item = Item::findOrFail($cart->item_id);
                    $item->stock = $item->stock - $cart->quantity;
                    $item->save();

                    if(!$transD->save()){
                        throw new \Exception("Payment failed");
                    }
                }
    
                if(!CartDetail::whereIn('id', $selectedItems)->delete()){
                    throw new \Exception("Payment failed");
                }
                
                DB::commit();
    
                return redirect(route("transaction"))
                    ->with("success", "Payment successfull");
                
            } catch (\Exepction $th) {
                DB::rollBack();
    
                return redirect(route("cart"))
                ->with("error", $e->getMessage());
            }
        }
        else{
            return redirect(route("cart"))
                ->with("error", "Payment failed");
        }
    }
    
    public function delete($id) {
        CartDetail::findOrFail($id)->delete();
        return back()->with('success', 'Item removed from cart');
    }
    
    public function update(Request $request, $id) {
        $cart = CartDetail::findOrFail($id);
        $item = Item::where('id', $cart->item_id)->first();

        if ($request->has('quantity')) { 
            $totStock = CartDetail::where('user_id', auth()->id())->where('item_id', $cart->item_id)->sum('quantity');
            $newTotalQuantity = $totStock - $cart->quantity + $request->quantity; 

            if ($newTotalQuantity <= $item->stock) {
                $cart->quantity = $request->quantity;
                $cart->total_price = $request->quantity * $item->price * ($cart->duration ?? 1);
        
                $cart->save();
        
                return response()->json([
                    'success' => true,
                    'newPrice' => $cart->total_price,
                    'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity exceeds stock.',
                    'newPrice' => $cart->total_price,
                    'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
                ]);
            }
        }

        if ($request->has('duration')) { 
            if ($request->duration > 0) {
                $cart->duration = $request->duration;
                $cart->total_price = $cart->quantity * $item->price * $request->duration;
        
                $cart->save();
        
                return response()->json([
                    'success' => true,
                    'newPrice' => $cart->total_price,
                    'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Duration must be greater than 0.',
                    'newPrice' => $cart->total_price,
                    'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
                ]);
            }
        }
    
        return response()->json([
            'success' => false,
            'message' => 'No valid fields to update.',
            'newPrice' => $cart->total_price,
            'newTotal' => CartDetail::where('user_id', auth()->id())->sum('total_price')
        ]);
    }
}
