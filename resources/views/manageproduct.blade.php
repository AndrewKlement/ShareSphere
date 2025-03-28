@extends("layouts.app")
@vite(['resources/js/manageproduct.js'])
@section("title", "Manage Product")
@section("content")

<ul class="list-group items-cont">
    @foreach ($items as $item)
        <li class="list-group-item">
            <img src="/storage/{{$item->item_images->first()->path}}" class="item-image">
            
            <div class="item-info">
                <div class="pname">{{$item->name}}</div>
                <div class="price">Rp {{$item->price}} /day</div>
                @if ($item->stock <= 1)
                <div class="stock">{{$item->stock}} pc</div>
                @else
                <div class="stock">{{$item->stock}} pcs</div>
                @endif
            </div>

            <div class="item-actions">
                <a class="btn btn-primary" href="{{route("editProduct", $item->id)}}" >Edit</a>
                
                <form action="{{route("manageProduct.delete", $item->id)}}" method="POST" class="btn-manage">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </li>
    @endforeach
</ul>

@endsection