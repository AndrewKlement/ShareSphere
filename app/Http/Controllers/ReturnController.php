<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use App\Models\ReturnDetail;
use App\Models\ReturnHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ReturnController extends Controller{

    public function viewDue()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $trans = TransactionHeader::with([
            'transactionDetail' => function ($query) {
                $query->whereColumn('quantity_return', '<', 'quantity');
            },
            'transactionDetail.item' => function ($query) {
                $query->withTrashed();
            },
            'transactionDetail.item.item_images' => function ($query) {
                $query->where('img_position', 1)
                      ->orWhereNotIn('id', function ($subquery) {
                          $subquery->select('id')
                                   ->from('item_images')
                                   ->where('img_position', 1);
                      })
                      ->orderBy('img_position', 'asc')
                      ->orderBy('created_at', 'asc');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->where('user_id', $userId)
        ->get();

        return view('returndue', compact('trans'));
    }

    public function viewReturn(){
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $returns = ReturnHeader::with([
            'returnDetail.item' => function ($query) {
                $query->withTrashed();
            },
            'returnDetail.item.item_images' => function ($query) {
                $query->where('img_position', 1)
                      ->orWhereNotIn('id', function ($subquery) {
                          $subquery->select('id')
                                   ->from('item_images')
                                   ->where('img_position', 1);
                      })
                      ->orderBy('img_position', 'asc')
                      ->orderBy('created_at', 'asc');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->where('user_id', $userId)
        ->get();

        return view('return', compact('returns'));
    }

    public function viewReturnRequest(){
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $returns = ReturnDetail::with([
            'item' => function ($query) {
                $query->withTrashed();
            },
            'item.item_images' => function ($query) {
                $query->where('img_position', 1)
                      ->orWhereNotIn('id', function ($subquery) {
                          $subquery->select('id')
                                   ->from('item_images')
                                   ->where('img_position', 1);
                      })
                      ->orderBy('img_position', 'asc')
                      ->orderBy('created_at', 'asc');
            }
        ])
        ->whereHas('item', function ($query) use ($userId) {
            $query->withTrashed()->where('user_id', $userId);
        })
        ->where('confirmed', false)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('returnrequest', compact('returns'));
    }

    public function confirmReturnRequest(Request $request, $id)
    {
        Log::info("Confirm Return Request ID: $id", ['request' => $request->all()]);
    
        $returnRequest = ReturnDetail::find($id);
    
        if (!$returnRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }

        DB::beginTransaction();
    
        try {

            DB::commit();
            $returnRequest->confirmed = true;
                       
            if(!$returnRequest->save()){
                throw new \Exception("Confirm failed");
            }

            $item = Item::find($returnRequest->item_id);
            $item->stock = $item->stock + $returnRequest->quantity;

            if(!$item->save()){
                throw new \Exception("Confirm failed");
            }    

        } catch (\Exepction $th) {
            DB::rollBack();

            return redirect(route("returnRequest"))
            ->with("error", $e->getMessage());
        }

    
        return response()->json([
            'success' => true
        ]);
    }

    public function requestReturn(Request $request){
        if (!$request->filled('selected_items') || empty($request->selected_items)) {
            return redirect()->route('cart');
        }

        $selectedItems = explode(',', $request->selected_items);
    
        $trans = TransactionDetail::with([
            'item' => function ($query) {
                $query->withTrashed();
            },
            'item.item_images' => function ($query) {
                $query->where('img_position', 1)
                      ->orWhereNotIn('id', function ($subquery) {
                          $subquery->select('id')
                                   ->from('item_images')
                                   ->where('img_position', 1);
                      })
                      ->orderBy('img_position', 'asc')
                      ->orderBy('created_at', 'asc');
            }
        ])
        ->whereIn('id', $selectedItems)
        ->get();

        return view('returnprocess', compact('trans'));
    }

    public function processReturn(Request $request){
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $selectedItems = collect(json_decode($request->selected_items, true))
        ->map(fn($id) => (int) $id)
        ->toArray();

        $trans = TransactionDetail::whereIn('id', $selectedItems)->get();

        if (!empty($selectedItems)) {
            DB::beginTransaction();
    
            try {
                $returnHead = new ReturnHeader();
                $returnHead->user_id = $userId;
    
                if(!$returnHead->save()){
                    throw new \Exception("Return failed");
                }
    
                $saveHeadId = $returnHead->id;
                
                foreach($trans as $td){
                    $returnD = new ReturnDetail();
                    $returnD->fill([
                        'return_header_id' => $saveHeadId,
                        'transaction_detail_id' => $td->id,
                        'item_id' => $td->item_id,
                        'quantity' => $td->quantity,
                        'confirmed' => false,
                    ]);

                    $transaction = TransactionDetail::findOrFail($td->id);
                    $transaction->quantity_return = $td->quantity;
                    $transaction->save();

                    if(!$returnD->save()){
                        throw new \Exception("Return failed");
                    }
                }
                
                DB::commit();
    
                return redirect(route("returnDue"))
                    ->with("success", "Return successfull");
                
            } catch (\Exepction $th) {
                DB::rollBack();
    
                return redirect(route("returnDue"))
                ->with("error", $e->getMessage());
            }
        }
        else{
            return redirect(route("returnDue"))
                ->with("error", "Return failed");
        }
    }


}
