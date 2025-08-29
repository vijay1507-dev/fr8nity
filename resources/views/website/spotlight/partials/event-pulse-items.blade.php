@if($eventPulseItems->count() > 0)
    @foreach($eventPulseItems as $item)
    <div class="row mx-auto">
        <div class="gradient_rounded radies_20 mb-3">
            <div class="col-12 radies_20 blacklight">
                <div class="row align-items-center px-1 px-lg-3 py-2 py-lg-0">
                    <div class="col-4 col-lg-2 mx-0 mb-3 mb-lg-0 py-3">
                        <div class="event_img">
                            @if($item->feature_image)
                                <img src="{{ asset('storage/' . $item->feature_image) }}" alt="{{ $item->title }}" class="img-fluid rounded" style="height: 100px; object-fit: cover; width: 100%;">
                            @else
                                <img src="{{ asset('images/our_story.jpg') }}" alt="{{ $item->title }}" class="img-fluid rounded" style="height: 100px; object-fit: cover; width: 100%;">
                            @endif
                        </div>
                    </div>
                    <div class="col-8">
                        <h5 class="mb-2 text-white">{{ $item->title }}</h5>
                        <p class="fs-6 mb-0">
                            {{ Str::limit($item->description, 150) }}
                        </p>
                    </div>
                    <div class="col-12 col-md-2 text-md-end text-center mt-3 mt-md-0">
                        <a href="{{ route('spotlight.event-pulse.detail', $item->id) }}" class="btn btnbg fe-semibold">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif