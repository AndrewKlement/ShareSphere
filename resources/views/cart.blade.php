@extends("layouts.app")
@vite(['resources/js/cart.js'])
@section("title", "Cart")
@section("content")

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="cont">
    <div class="list-group">
        @foreach ($groupedCarts as $carts)
            <div class="sname">{{ $carts->first()->item->user->name }}</div>
            <ul class="items-cont">
                @foreach ($carts as $cart)
                <li class="list-group-item">
                    
                    @if(!$cart->item->trashed())
                    <input class="cart-checkbox" id="checkbox{{ $cart->id }}" type="checkbox" name="selected_items[]" value="{{$cart->id}}" data-price="{{$cart->total_price}}">                                
                    @else
                    <input type="checkbox" disabled>
                    @endif

                    <img src="/storage/{{$cart->item->item_images->first()->path}}" class="item-image">
                    
                    <div class="item-info">
                        <a href="{{ route('viewProduct', ['id' => $cart->item->id]) }}" class="item-info text-decoration-none text-dark">
                        <div class="pname">{{$cart->item->name}}</div>
                        
                        @if(!$cart->item->trashed())
                        <div class="price" id="price{{ $cart->id }}">Rp {{$cart->total_price}}</div>
                        @endif
                        
                        @if($cart->item->trashed())
                        <div class="text-danger stock">Out of stock</div>
                        @endif
                        </a>
                    </div>

                    @if(!$cart->item->trashed())
                        <div class="inpt-cont">
                            Quantity
                            <div class="quantity-input">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-id="{{ $cart->id }}" data-amount="-1">-</button>
                                <div class="quantity" >{{ $cart->quantity }}</div>
                                <button type="button" class="btn btn-outline-secondary quantity-btn" data-id="{{ $cart->id }}" data-amount="1">+</button>
                            </div>
                        </div>


                        <div class="inpt-cont">
                            Duration
                            <div class="duration-input">
                                <button type="button" class="btn btn-outline-secondary duration-btn" data-id="{{ $cart->id }}" data-amount="-1">-</button>
                                <div class="duration" >{{ $cart->duration }}</div>
                                <button type="button" class="btn btn-outline-secondary duration-btn" data-id="{{ $cart->id }}" data-amount="1">+</button>
                            </div>
                        </div>
                    @endif

                    <div class="dlt-btn">
                        <form method="POST" action="{{ route('cart.delete', $cart->id) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
        @endforeach
    </div>

    <form id="cart-form" method="POST" action="{{route("cart.processPurchase")}}">
        @csrf
        <div class="details">
            <div class="total-price">
                Total: Rp <span id="total-price">0</span>
            </div>
            <input type="hidden" name="selected_items" id="selected-items">
            <button type="submit" class="btn btn-primary" id="purchase-btn" disabled>Purchase</button>
        </div>
    </form>
</div>
@endsection