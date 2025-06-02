@extends("layouts.app")
@vite(['resources/js/returndue.js'])
@section("title", "Return Due")
@section("content")

@php
    $pastDue = False                        
@endphp

<div class="cont">
    <div class="list-cont">
        <div class="list-group">
            <div class="label">Upcoming</div>
            @foreach ($trans as $tran)
                @foreach ($tran->transactionDetail as $td)
                    @php
                        $created_at = new DateTime($td->created_at);
                        $duration = $td->duration;
                        $due_date = $created_at->modify("+{$duration} days");
    
                        $today = new DateTime();
                        $diff = $today->diff($due_date);
                        $remaining_days = $diff->days;
                        $is_overdue = $today > $due_date && $diff->days > 0;
                        @endphp
    
                    @if (!$is_overdue)
                        <li class="list-group-item">
                            <input class="return-checkbox" id="checkbox{{ $td->id }}" type="checkbox" name="selected_items[]" value="{{$td->id}}" data-amount="{{$td->quantity}}">                                
    
                            <a href="{{ route('viewProduct', ['id' => $td->item->id]) }}" class="item-info text-decoration-none text-dark">
                                <img src="/storage/{{$td->item->item_images->first()->path}}" class="item-image">
                                
                                <div class="text-body">
                                    <div class="pname">{{$td->item->name}}</div>
                                    <div class="row-info">
                                        <div class="desc-cont">
                                            <div class="price">{{$td->quantity}} x Rp {{$td->item->price}} x {{$td->duration}} days</div>
                                            <div class="due">
                                                due on {{ $due_date->format('Y-m-d') }} 
                                                ({{ $remaining_days == 0 ? 'today' : ($remaining_days == 1 ? '1 day' : $remaining_days . ' days') }})
                                            </div>
                                        </div>
                                        <div class="total">Total: Rp {{$td->total_price}}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @else
                        @php
                            $pastDue = True  
                        @endphp
                    @endif
                @endforeach
            @endforeach  
        </div>
    
        @if ($pastDue)
        <div class="list-group">
            <div class="label">Past Due</div>
            @foreach ($trans as $tran)
                @foreach ($tran->transactionDetail as $td)
                    @php
                        $created_at = new DateTime($td->created_at);
                        $duration = $td->duration;
                        $due_date = $created_at->modify("+{$duration} days");
    
                        $today = new DateTime();
                        $diff = $today->diff($due_date);
                        $remaining_days = $diff->days;
                        $is_overdue = $today > $due_date && $diff->days > 0;
                        @endphp
    
                    @if ($is_overdue)
                        <li class="list-group-item">
                            <input class="return-checkbox" id="checkbox{{ $td->id }}" type="checkbox" name="selected_items[]" value="{{$td->id}}" data-amount="{{$td->quantity}}">                                

                            <a href="{{ route('viewProduct', ['id' => $td->item->id]) }}" class="item-info text-decoration-none text-dark">
                                <img src="/storage/{{$td->item->item_images->first()->path}}" class="item-image">
                                <div class="pname">{{$td->item->name}}</div>
                                <div class="desc-cont">
                                    <div class="price">{{$td->quantity}} x Rp {{$td->item->price}} x {{$td->duration}} days</div>
                                    <div class="due">
                                        due on {{ $due_date->format('Y-m-d') }} 
                                        (-{{ $remaining_days == 0 ? 'today' : ($remaining_days == 1 ? '1 day' : $remaining_days . ' days') }})
                                    </div>
                                </div>
                                <div class="total">Total: Rp {{$td->total_price}}</div>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endforeach  
        </div>
        @endif
    </div>

    <form id="return-form" method="POST" action="{{route("return.request")}}">
        @csrf
        <div class="details">
            <div class="total-quantity">
                Total: <span id="total-quantity">0</span> pcs
            </div>
            <input type="hidden" name="selected_items" id="selected-items">
            <button type="submit" class="btn btn-primary" id="return-btn" disabled>Return</button>
        </div>
    </form>
</div>

@endsection