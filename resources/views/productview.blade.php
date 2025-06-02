@extends("layouts.app")
@vite(['resources/js/productview.js'])
@section("title", "Product")
@section("content")

@if (!$item->deleted_at && $item->stock > 0)
    
<div class="content">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @php $idx = 0 @endphp
            @foreach ($item->item_images as $item_image)
                <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                    <img src="/storage/{{$item_image->path}}" class="d-block w-100 images">
                </div>
                @php $idx++; @endphp
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="item">
        <p class="item-name">{{$item->name}}</p>
        <p class="item-price">Rp{{$item->price}} /day</p>
        <div class="item-desc">{{$item->description}}</div>
        <p class="item-shipping">Shipped from {{$item->shippingDetail->province}} jakarta, by {{$item->user->name}}</p>
        
        <div class="form">
            <form method="POST" action="{{ route('viewProduct.cart') }}">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
        
                <div class="input-cont">
                    <div class="quantity-container">
                        <div>Quantity</div>
                        <button type="button" class="btn btn-outline-secondary quantity-btn" data-amount="-1">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $item->stock }}" class="form-control text-center" style="width: 60px; display: inline-block;">
                        <button type="button" class="btn btn-outline-secondary quantity-btn" data-amount="1">+</button>
                    </div>

                    <div class="duaration-container">
                        <div>Duration (day)</div>
                        <button type="button" class="btn btn-outline-secondary duration-btn" data-amount="-1">-</button>
                        <input type="number" name="duration" id="duration" value="1" min="1" class="form-control text-center" style="width: 60px; display: inline-block;">
                        <button type="button" class="btn btn-outline-secondary duration-btn" data-amount="1">+</button>
                    </div>
                </div>
        
                <button type="submit" class="btn btn-success mt-2">Add to Cart</button>
            </form>
        
            <form method="POST" action="{{ route('viewProduct.buy') }}">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                <input type="hidden" name="quantity" id="buy-duration" value="1">
        
                <button type="submit" class="btn btn-primary mt-2">Buy Now</button>
            </form>
        </div>
    </div>
</div>

@elseif(!$item->deleted_at && $item->stock <= 0)

<div class="alert alert-danger">
    Item is out of stock
</div>

<div class="content">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @php $idx = 0 @endphp
            @foreach ($item->item_images as $item_image)
                <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                    <img src="/storage/{{$item_image->path}}" class="d-block w-100 images">
                </div>
                @php $idx++; @endphp
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="item">
        <p class="item-name">{{$item->name}}</p>
        <p class="item-price">Rp{{$item->price}} /day</p>
        <h6 class="item-desc">{{$item->description}}</h6>
        <p class="item-shipping">Shipped from {{$item->shippingDetail->province}} jakarta, by {{$item->user->name}}</p>
    </div>
</div>

@else

<div class="alert alert-danger">
    This item has been DELETED
</div>

<div class="content">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @php $idx = 0 @endphp
            @foreach ($item->item_images as $item_image)
                <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                    <img src="/storage/{{$item_image->path}}" class="d-block w-100 images">
                </div>
                @php $idx++; @endphp
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="item">
        <p class="item-name">{{$item->name}}</p>
        <p class="item-price">Rp{{$item->price}} /day</p>
        <h6 class="item-desc">{{$item->description}}</h6>
        <p class="item-shipping">Shipped from {{$item->shippingDetail->province}} jakarta, by {{$item->user->name}}</p>
    </div>
</div>

@endif

@endsection