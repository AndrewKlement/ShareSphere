@extends("layouts.app")
@section("title", "Transaction")
@vite(['resources/js/transaction.js'])
@section("content")
    <div class="list-group">
        @foreach ($trans as $tran)
            @php
                $accordionId = 'accordion-' . $loop->index;
                $firstItem = $tran->transactionDetail->first();
                $hasMultipleItems = count($tran->transactionDetail) > 1;
            @endphp
            <div class="items-cont">
                <div class="sname">Rented on {{ $tran->created_at->format('Y-m-d') }}</div>

                @if ($hasMultipleItems)
                    <li class="accordion-item list-group-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#{{ $accordionId }}" 
                                aria-expanded="false" aria-controls="{{ $accordionId }}">
                                <div class="item-info-btn-cont">
                                    <div class="item-info-btn">
                                        <a href="{{ route('viewProduct', ['id' => $firstItem->item->id]) }}" class="item-info-btn text-decoration-none text-dark">
                                            @php
                                                $created_at = new DateTime($firstItem->created_at);
                                                $duration = $firstItem->duration;
                                                $due_date = $created_at->modify("+{$duration} days");
                        
                                                $today = new DateTime();
                                                $remaining_days = $today->diff($due_date)->days;
                                            @endphp
                                            
                                            <img src="/storage/{{$firstItem->item->item_images->first()->path}}" class="item-image">
                                            <div class="pname">{{$firstItem->item->name}}</div>
                                            
                                            <div class="desc-cont d-none">
                                                <div class="price">{{$firstItem->quantity}} x Rp {{$firstItem->item->price}} x {{$firstItem->duration}} days</div>
                                                <div class="due">due on {{ $due_date->format('Y-m-d') }} ({{ $remaining_days }} days)</div>
                                            </div>
                                            
                                            <div class="total d-none">Total: Rp {{$firstItem->total_price}}</div>
                                        </a>
                                        @php
                                            $total_price = $tran->transactionDetail->flatten()->sum('total_price');
                                        @endphp
                                        <div class="othProd">
                                            <div class="total-p">Total: Rp {{ $total_price }}</div>
                                            <div class="oth-cnt">({{ count($tran->transactionDetail) - 1 }}) other products</div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="{{ $accordionId }}" class="accordion-collapse collapse" data-bs-parent=".list-group">
                            <div class="accordion-body">
                                @foreach ($tran->transactionDetail->skip(1) as $td)
                                @php
                                    $created_at = new DateTime($td->created_at);
                                    $duration = $td->duration;
                                    $due_date = $created_at->modify("+{$duration} days");
            
                                    $today = new DateTime();
                                    $remaining_days = $today->diff($due_date)->days;
                                @endphp

                                    <a href="{{ route('viewProduct', ['id' => $td->item->id]) }}" class="item-info text-decoration-none text-dark">
                                        <img src="/storage/{{$td->item->item_images->first()->path}}" class="item-image">
                                        <div class="pname">{{$td->item->name}}</div>
                                        <div class="desc-cont">
                                            <div class="price">{{$td->quantity}} x Rp {{$td->item->price}} x {{$td->duration}} days</div>
                                            <div class="due">due on {{ $due_date->format('Y-m-d') }} ({{ $remaining_days }} days)</div>
                                        </div>
                                        <div class="total">Total: Rp {{$td->total_price}}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @else
                    @php
                        $created_at = new DateTime($firstItem->created_at);
                        $duration = $firstItem->duration;
                        $due_date = $created_at->modify("+{$duration} days");

                        $today = new DateTime();
                        $remaining_days = $today->diff($due_date)->days;
                    @endphp
                    <li class="list-group-item">
                        <a href="{{ route('viewProduct', ['id' => $firstItem->item->id]) }}" class="item-info text-decoration-none text-dark">
                            <img src="/storage/{{$firstItem->item->item_images->first()->path}}" class="item-image">
                            <div class="pname">{{$firstItem->item->name}}</div>
                            <div class="desc-cont">
                                <div class="price">{{$firstItem->quantity}} x Rp {{$firstItem->item->price}} x {{$firstItem->duration}} days</div>
                                <div class="due">due on {{ $due_date->format('Y-m-d') }} ({{ $remaining_days }} days)</div>
                            </div>
                            <div class="total">Total: Rp {{$firstItem->total_price}}</div>
                        </a>
                    </li>
                @endif
            </div>
        @endforeach
    </div>
@endsection
