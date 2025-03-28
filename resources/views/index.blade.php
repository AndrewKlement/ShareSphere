@extends("layouts.app")
@vite(['resources/js/index.js'])
@section("title", "Home")
@section("content")

<div class="items-cont">
@foreach ($items as $item)
<a href="{{ route('viewProduct', ['id' => $item->id]) }}" class="text-decoration-none text-dark">
    <div class="card">
        <img src="/storage/{{$item->item_images->first()->path}}" class="card-img-top item-image">
        <div class="card-body">
            <h5 class="card-title title">{{$item->name}}</h5>
            <div class="desc">
                <h6 class="card-subtitle mb-1 text-body-secondary">Rp{{$item->price}} /day</h6>
                <p class="card-text item-text">{{$item->user->name}}</p>
                <p class="card-text item-text">{{$item->shippingDetail->province}} jakarta</p>
            </div>
        </div>
    </div>
</a>
@endforeach
</div>

@endsection