<?php

namespace App\Http\Controllers; 
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller{


    public function index()
    {
        $items = Item::with('user')->with('thumbnail')->get();

        return view("index", compact('items'));
    }

}
