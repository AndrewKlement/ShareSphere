@extends("layouts.app")
@vite(['resources/js/shippingdetail.js'])
@section("title", "Shipping Detail")
@section("content")

@if ($shippingdetail)
    <form class="form-cont form" method="POST" action="{{route('shippingDetail.post')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" pattern="(\+62|62|0)[2-9]\d{7,10}" class="form-control" id="phone" aria-describedby="telpHelp" name="phone" value="{{$shippingdetail->phone_number}}">
        
            @if ($errors->has("telp"))
                <div id="telpHelp" class="form-text text-danger">Phone number required</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="selectProvince" class="form-label">Select an area in Jakarta:</label>
            <select id="selectProvince" class="form-select" name="selectProvince">
                <?php 
                    $selectedProvince = $shippingdetail->province ?? '';
                ?>
                <option id="central" value="central" <?= ($selectedProvince == 'central') ? 'selected' : '' ?>>Central Jakarta</option>
                <option id="north" value="north" <?= ($selectedProvince == 'north') ? 'selected' : '' ?>>North Jakarta</option>
                <option id="west" value="west" <?= ($selectedProvince == 'west') ? 'selected' : '' ?>>West Jakarta</option>
                <option id="south" value="south" <?= ($selectedProvince == 'south') ? 'selected' : '' ?>>South Jakarta</option>
                <option id="east" value="east" <?= ($selectedProvince == 'east') ? 'selected' : '' ?>>East Jakarta</option>
                <option id="thousand-islands" value="thousand-islands" <?= ($selectedProvince == 'thousand-islands') ? 'selected' : '' ?>>Thousand Islands (Kepulauan Seribu)</option>
            </select>

            @if ($errors->has("selectProvince"))
                <div id="categoryHelp" class="form-text text-danger">Province required</div>
            @endif
        </div>
        
        <div class="mb-3">
            <label for="postcode" class="form-label">Postal Code</label>
            <input type="number" class="form-control" id="postcode" aria-describedby="postcodeHelp" name="postcode" value="{{$shippingdetail->postal_code}}">
                    
            @if ($errors->has("postcode"))
                <div id="postcode" class="form-text text-danger">Post Code required</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Full Address</label>
            <input type="text" class="form-control" id="address" aria-describedby="addressHelp" name="address" value="{{$shippingdetail->address}}"">
        
            @if ($errors->has("address"))
                <div id="addressHelp" class="form-text text-danger">Full Address required</div>
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@else
    <form class="form-cont form" method="POST" action="{{route('shippingDetail.post')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" pattern="(\+62|62|0)[2-9]\d{7,10}" class="form-control" id="phone" aria-describedby="telpHelp" name="phone">
        
            @if ($errors->has("telp"))
                <div id="telpHelp" class="form-text text-danger">Phone number required</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="selectProvince" class="form-label">Select an area in Jakarta:</label>
            <select id="selectProvince" class="form-select" name="selectProvince">
                <option value="" selected disabled hidden>Choose here</option>
                <option value="central">Central Jakarta</option>
                <option value="north">North Jakarta</option>
                <option value="west">West Jakarta</option>
                <option value="south">South Jakarta</option>
                <option value="east">East Jakarta</option>
                <option value="thousand-islands">Thousand Islands (Kepulauan Seribu)</option>        
            </select>

            @if ($errors->has("selectProvince"))
                <div id="categoryHelp" class="form-text text-danger">Province required</div>
            @endif
        </div>
        
        <div class="mb-3">
            <label for="postcode" class="form-label">Postal Code</label>
            <input type="number" class="form-control" id="postcode" aria-describedby="postcodeHelp" name="postcode">
                    
            @if ($errors->has("postcode"))
                <div id="postcode" class="form-text text-danger">Post Code required</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Full Address</label>
            <input type="text" class="form-control" id="address" aria-describedby="addressHelp" name="address">
        
            @if ($errors->has("address"))
                <div id="addressHelp" class="form-text text-danger">Full Address required</div>
            @endif
        </div>

        
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endif


@endsection