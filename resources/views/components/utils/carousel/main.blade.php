<div id="mainCarousel" class="carousel slide text-dark mb-3 d-none d-lg-flex" data-ride="carousel" style="height:15rem;">
    <ol class="carousel-indicators">
        @php $index = 0; @endphp
        @foreach ($carouselItems as $item)
            <li data-target="#mainCarousel" data-slide-to="{{ $index }}" @if (0 == $index) class="active" @endif></li>
            @php $index++; @endphp
        @endforeach
    </ol>
    <div class="carousel-inner">
        @php $index = 0; @endphp
        @foreach ($carouselItems as $item)
        <div class="carousel-item @if (0 == $index) active @endif">
            <img src="{{$item->image->url}}" alt="{{$item->image->name}}" style="width:100%;height: 16rem;">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="text-dark">{{$item->title}}</h5>
                <p class="text-dark">{{$item->description}}</p>
            </div>
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
