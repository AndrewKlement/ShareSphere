@extends("layouts.app")
@vite(['resources/js/checkout.js'])
@section("title", "Cart")
@section("content")

<div class="cont">
    <div class="list-group">
        @foreach ($groupedCarts as $carts)
            <div class="sname">{{ $carts->first()->item->user->name }}</div>
            <ul class="items-cont">
                @foreach ($carts as $cart)
                <li class="list-group-item">
                    <img src="/storage/{{$cart->item->item_images->first()->path}}" class="item-image">
                    
                    <div class="item-info">
                        <div class="pname">{{$cart->item->name}}</div>
                        
                        <div class="price">{{ $cart->quantity }} x Rp {{$cart->item->price}} x {{ $cart->duration }} days</div>
                    </div>
                </li>
                @endforeach
            </ul>
        @endforeach
    </div>

    <form id="cart-form" method="POST" action="{{ route("cart.processPayment") }}">
        @csrf

        @php
            $total_quant = $groupedCarts->flatten()->sum('quantity');
            $total = $groupedCarts->flatten()->sum('total_price');
        @endphp
        <div class="details">
            <div class="total-price">
                Total price ({{ $total_quant }} items): Rp {{ $total }} 
            </div>
            <input type="hidden" name="selected_items" id="selected-items" value="{{ $groupedCarts->flatten()->pluck('id') }}">
            <button type="submit" class="btn btn-primary" id="purchase-btn">Purchase</button>
        </div>
    </form>
</div>
@endsection