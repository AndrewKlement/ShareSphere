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
        $item->fill([
            'name' => $request->pname,
            'category_id' => $request->selectCategory,
            'description' => $request->desc,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => $userId
        ]);
        
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
                $itemimage->img_position = $i;
                
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
        }])->where('user_id', $userId)->get();
        
        return view("manageproduct", compact('items'));
    }

    public function manageProductDelete($itemId)
    {
        if (Auth::check()) {
            $userId = Auth::id(); // Get authenticated user ID
        } else {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $item = Item::with('item_images')->findOrFail($itemId);

        if($item->user_id == $userId){
            try {
                DB::beginTransaction();
            
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
        return redirect()->back()->with('error', 'Item not found');
    }

    public function editProduct($itemId){
        $item = Item::with(['item_images' => function ($query) {
            $query->orderBy('img_position', 'asc');
        }])->find($itemId);
        $categories = Category::all();
        
        return view("editproduct", compact('item', 'categories'));
    }

    public function editProductPatch(Request $request, $itemId){
        $request->validate([
            "pname" => "required",
            "selectCategory" => "required",
            "desc" => "required",
            "price" => "required",
            "stock" => "required"
        ]);
        
        $item = Item::with('item_images')->find($itemId);
        $imagecount = $item->item_images->count();

        $hasFile = false;
        $modifiedCount = 0;
        for ($i = 1; $i <= 5; $i++) {
            if($request->filled("imageId$i")){
                $modifiedCount++;
            }
            if ($request->hasFile("inputimage$i")) {
                $hasFile = true;
            }
        }
        
        if (!$hasFile && $modifiedCount >= $imagecount) {
            return back()->withErrors(['inputimage' => 'At least one image is required.'])->withInput();
        }

        $item->name = $request->pname;
        $item->category_id = $request->selectCategory;
        $item->description = $request->desc;
        $item->price = $request->price;
        $item->stock = $request->stock;
        
        if(!$item->save()){
            return redirect(route("editProduct", $itemId))
            ->with("error", "Failed to edit item");
        }

        $imagePos = [];
        for ($i = 1; $i <= 5; $i++) {
            if($request->filled("imageId$i")){
                $item_image =  $item->item_images->firstWhere('img_position', $request->input("imageId$i"));;
                
                if ($item_image) {
                    Storage::disk('public')->delete($item_image->path);
                    $item_image->delete();
                    
                    $imagePos[] = $request->input("imageId$i");
                }
            }
        }

        $imageIDIDX = 0;
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("inputimage$i") && $request->file("inputimage$i")->isValid()) {
                $path = $request->file("inputimage$i")->store('images', 'public');
        
                $itemimage = new ItemImage;       
                $itemimage->item_id = $itemId;
                $itemimage->path = $path;
                $itemimage->img_position = $imagePos[$imageIDIDX] ?? $i;
        
                if (!$itemimage->save()) {
                    return redirect(route("editProduct", $itemId))->with("error", "Failed to create item");
                }
            }
        }

        return redirect(route("manageProduct"))->with("success", "Item Created");;
    }
}