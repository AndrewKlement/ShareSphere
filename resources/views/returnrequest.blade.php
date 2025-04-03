@extends("layouts.app")
@section("title", "Return Request")
@vite(['resources/js/returnrequest.js'])
@section("content")

<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="list-group">
    <div class="label">Requests (confirm return to remove)</div>
    @foreach ($returns as $request)
        <li class="list-group-item" id="list-group-item{{ $request->id }}">
            <a href="{{ route('viewProduct', ['id' => $request->item->id]) }}" class="item-info text-decoration-none text-dark">
                <img src="/storage/{{$request->item->item_images->first()->path}}" class="item-image">
                <div class="pname">{{$request->item->name}}</div>
                <div class="quantity">{{$request->quantity}} pcs</div>
            </a>
                <button type="button" class="btn btn-primary" id="confirm-btn" data-id="{{ $request->id }}">Confirm</button>
        </li>
    @endforeach  
</div>
@endsection
