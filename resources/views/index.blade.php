@extends("layouts.app")
@vite(['resources/js/index.js'])
@section("title", "Home")
@section("content")

@if (session()->has("success"))
    <div class="alert alert-success">
        {{session()->get("success")}}
    </div>
@endif

<div class="items-cont">
@foreach ($items as $item)
    <div class="card">
        <img src="/storage/{{$item->item_images->first()->path}}" class="card-img-top item-image">
        <div class="card-body">
            <h5 class="card-title title">{{$item->name}}</h5>
            <div class="desc">
                <h6 class="card-subtitle mb-1 text-body-secondary">Rp {{$item->price}}</h6>
                <p class="card-text item-text">{{$item->user->name}}</p>
                <p class="card-text item-text">{{$item->shippingDetail->province}} jakarta</p>
            </div>
        </div>
    </div>
@endforeach
</div>

@endsection