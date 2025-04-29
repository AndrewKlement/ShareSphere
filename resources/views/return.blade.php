@extends("layouts.app")
@section("title", "Return")
@vite(['resources/js/return.js'])
@section("content")
    <div class="list-group">
        @foreach ($returns as $return)
            @php
                $accordionId = 'accordion-' . $loop->index;
                $firstItem = $return->returnDetail->first();
                $hasMultipleItems = count($return->returnDetail) > 1;
            @endphp
            <div class="items-cont">
                <div class="sname">Rented on {{ $return->created_at->format('Y-m-d') }}</div>

                @if ($hasMultipleItems)
                    <li class="accordion-item list-group-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#{{ $accordionId }}" 
                                aria-expanded="false" aria-controls="{{ $accordionId }}">
                                <div class="item-info-btn-cont">
                                    <div class="item-info-btn">
                                        <a href="{{ route('viewProduct', ['id' => $firstItem->item->id]) }}" class="item-info-btn text-decoration-none text-dark">
                                            <img src="/storage/{{$firstItem->item->item_images->first()->path}}" class="item-image">
                                            <div class="pname">{{$firstItem->item->name}}</div>
                                            <div class="status d-none">{{($firstItem->confirmed)?'CONFIRMED':'PENDING'}}</div>
                                        </a>

                                        @php
                                            $total_price = $return->returnDetail->flatten()->sum('total_price');
                                            @endphp
                                        <div class="othProd">
                                            <div class="status-p">{{($firstItem->confirmed)?'CONFIRMED':'PENDING'}}</div>
                                            <div class="oth-cnt">({{ count($return->returnDetail) - 1 }}) other products</div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="{{ $accordionId }}" class="accordion-collapse collapse" data-bs-parent=".list-group">
                            <div class="accordion-body">
                                @foreach ($return->returnDetail->skip(1) as $rd)
                                    <a href="{{ route('viewProduct', ['id' => $rd->item->id]) }}" class="item-info text-decoration-none text-dark">
                                        <img src="/storage/{{$rd->item->item_images->first()->path}}" class="item-image">
                                        <div class="pname">{{$rd->item->name}}</div>
                                        <div class="status">{{($firstItem->confirmed)?'CONFIRMED':'PENDING'}}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @else
                    <li class="list-group-item">
                        <a href="{{ route('viewProduct', ['id' => $firstItem->item->id]) }}" class="item-info text-decoration-none text-dark">
                            <img src="/storage/{{$firstItem->item->item_images->first()->path}}" class="item-image">
                            <div class="pname">{{$firstItem->item->name}}</div>
                            <div class="status">{{($firstItem->confirmed)?'CONFIRMED':'PENDING'}}</div>
                        </a>
                    </li>
                @endif
            </div>
        @endforeach
    </div>
@endsection
