@extends("layouts.app")
@vite(['resources/js/checkout.js'])
@section("title", "Return")
@section("content")

@php
    $total_quant = 0;
@endphp

<div class="cont">
    <div class="list-group">
            @foreach ($trans as $td)
                @php
                    $total_quant += $td->quantity;
                @endphp

                <li class="list-group-item">
                    <img src="/storage/{{$td->item->item_images->first()->path}}" class="item-image">
                    
                    <div class="item-info">
                        <div class="pname">{{$td->item->name}}</div>
                        
                        <div class="price">{{ $td->quantity }} x Rp {{$td->item->price}} x {{ $td->duration }} days</div>
                    </div>
                </li>
            @endforeach
    </div>

    <form id="cart-form" method="POST" action="{{ route("return.process") }}">
        @csrf
        <div class="details">
            <div class="total-price">
                Total: {{ $total_quant }} pcs 
            </div>
            <input type="hidden" name="selected_items" id="selected-items" value="{{ $trans->flatten()->pluck('id') }}">
            <button type="submit" class="btn btn-primary" id="purchase-btn">Return</button>
        </div>
    </form>
</div>
@endsection