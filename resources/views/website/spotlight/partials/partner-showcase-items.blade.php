@if($partnerShowcaseItems->count() > 0)
    @php
        $chunkedItems = $partnerShowcaseItems->chunk(4);
    @endphp
    
    @foreach($chunkedItems as $rowItems)
    <div class="row mx-auto align-items-stretch pt-3">
        @foreach($rowItems as $item)
        <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="gradient_rounded radies_20 m-2 h-100">
                <a href="{{ route('spotlight.partner-showcase.detail', $item->id) }}" class="text-decoration-none d-block h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        @if($item->feature_image)
                            <img src="{{ asset('storage/' . $item->feature_image) }}" alt="{{ $item->title }}"
                                class="img-fluid mb-3" style="height: 180px; object-fit: cover; width: 100%;" />
                        @else
                            <img src="{{ asset('images/Mask group (3).png') }}" alt="{{ $item->title }}"
                                class="img-fluid mb-3" style="height: 180px; object-fit: cover; width: 100%;" />
                        @endif
                        <div class="card-content">
                            <div class="card-title">{{ $item->title }}</div>
                            <div class="card-desc">{{ Str::limit($item->description, 120) }}</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
@endif