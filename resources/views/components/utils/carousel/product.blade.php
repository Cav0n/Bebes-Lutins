<div id="mainCarousel" class="carousel slide text-dark mb-3 d-flex" data-ride="carousel">
    <div class="carousel-inner">
        @php $index = 0; @endphp
        @foreach ($product->images as $image)
        <div class="carousel-item @if (0 == $index) active @endif">
            <img class="w-100" src="{{ asset($image->url) }} " alt="{{ $image->name }}">
        </div>
        @php $index++; @endphp
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#mainCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#mainCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
