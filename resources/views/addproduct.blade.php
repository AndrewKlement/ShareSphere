@extends("layouts.app")
@vite(['resources/js/addproduct.js'])
@section("title", "Add Product")
@section("content")


<form class="form-cont form" method="POST" action="{{ route('addProduct.post') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="pname" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="pname" aria-describedby="pnameHelp" name="pname">
        <div id="pnameHelp" class="form-text">
            Product name min. 25 character by entering brand, product type, color, material, or model.
            It is recomended to avoid excessive use of capital letters, including more than one brand, and promotional word.
        </div>

        @if ($errors->has("pname"))
            <div id="pnameHelp" class="form-text text-danger">Product name required</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="selectCategory" class="form-label">Select Category</label>
        <select id="selectCategory" class="form-select" name="selectCategory">
            <option value="" selected disabled hidden>Choose here</option>
            @foreach ($categories as $i)
                <option value="{{$i->id}}">{{$i->name}}</option>
            @endforeach
        </select>

        @if ($errors->has("selectCategory"))
            <div id="categoryHelp" class="form-text text-danger">Category required</div>
        @endif
    </div>

    <label for="selectPicture" class="form-label">Select Picture</label>
    <div class="mb-3 images">
        @foreach (range(1, 5) as $i)
            <div class="image-cont" id="imagecont{{$i}}">
                <div class="imagescont" id="imagecont{{$i}}">
                    <img id="close{{$i}}" class="close-icon" src="{{ asset('images/close.svg') }}" alt="Logo">
                    <img id="image{{$i}}" src="{{ asset('images/image.png')}}" class="image"/>
                </div>  
                <label for="image{{$i}}" class="iamge-label">Picture {{$i}}</label>
                <input type="file" id="inputimage{{$i}}" accept="image/jpeg, image/png" style="display: none;" name="inputimage{{$i}}">
                <div id="fileContents"></div>
            </div>
        @endforeach
    </div>

    @if ($errors->has("inputimage"))
        <div id="inputimage" class="form-text text-danger">At least 1 image required</div>
    @endif

    <div class="">
        <label for="desc" class="form-labeal">Description</label>
        <textarea type="text" class="form-control desc" id="desc" aria-describedby="descHelp" name="desc"></textarea>
        <div id="descHelp" class="form-text">
            Make sure the product description includes a detailed explanation of your product so that buyers can easily understand and find it.
        </div>

        @if ($errors->has("desc"))
            <div id="desc" class="form-text text-danger">Description required</div>
        @endif
    </div> 

    <div class="mb-3">
        <label for="price-cont" class="form-label">Price</label>
        <div id="price-cont" class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" class="form-control" id="price" aria-describedby="priceHelp" name="price">
            <span class="input-group-text">/ Day</span>
        </div>
        <div id="priceHelp" class="form-text">
            Product rent price per day min. Rp100
        </div>

        @if ($errors->has("price"))
            <div id="price" class="form-text text-danger">Price required</div>
        @endif
    </div> 

    <div class="mb-3">
        <label for="stock" class="form-label">Stock Count</label>
        <input type="number" class="form-control" id="stock" aria-describedby="stockHelp" name="stock">
        <div id="stockHelp" class="form-text">
            Stock count min. 1 item
        </div>
        
        @if ($errors->has("stock"))
            <div id="stock" class="form-text text-danger">Stock required</div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection