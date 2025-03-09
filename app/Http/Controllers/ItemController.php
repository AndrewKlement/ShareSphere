<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class ItemController extends Controller
{
    //add product
    public function addProduct()
    {
        $categories = Category::all();
        return view("addproduct", compact('categories'));
    }

    public function addProductPost(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id(); // Get authenticated user ID
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $request->validate([
            "pname" => "required",
            "selectCategory" => "required",
            "desc" => "required",
            "price" => "required",
            "stock" => "required"
        ]);
        

        $hasFile = false;
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("inputimage$i")) {
                $hasFile = true;
                break;
            }
        }
        
        if (!$hasFile) {
            return back()->withErrors(['inputimage' => 'At least one image is required.'])->withInput();
        }


        $item = new Item();
        $item->name = $request->pname;
        $item->category_id = $request->selectCategory;
        $item->description = $request->desc;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->user_id = $userId;
        
        if(!$item->save()){
            return redirect(route("addProduct"))
            ->with("error", "Failed to create item");
        }

        $saveItemId = $item->id;
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("inputimage$i") && $request->file("inputimage$i")->isValid()) {
                $path = $request->file("inputimage$i")->store('images', 'public');

                $itemimage = new ItemImage;
                $itemimage->item_id = $saveItemId;
                $itemimage->path = $path;
                
                if(!$itemimage->save()){
                    return redirect(route("addProduct"))
                    ->with("error", "Failed to create item");
                }
            }
        }

        return redirect(route("home"))->with("success", "Item Created");;
    }

    // manage product
    public function manageProduct()
    {
        if (Auth::check()) {
            $userId = Auth::id(); // Get authenticated user ID
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $items = Item::with('thumbnail')->where('user_id', $userId)->get();

        return view("manageproduct", compact('items'));
    }

    public function manageProductDelete($itemId)
    {
        try {
            DB::beginTransaction();
    
            $item = Item::with('item_images')->find($itemId);
    
            if (!$item) {
                return redirect()->back()->with('error', 'Item not found.');
            }
            
            foreach($item->item_images as $image){
                Storage::disk('public')->delete($image->path);
            };


            $item->item_images()->delete();
    
            $item->delete();
    
            DB::commit();
            return redirect()->back()->with('success', 'Item deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting item: ' . $e->getMessage());
        }
    }
}