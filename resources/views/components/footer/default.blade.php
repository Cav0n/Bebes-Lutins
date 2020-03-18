<footer class="container-fluid row border-top bg-white justify-content-center mx-0">
    <div class="row col-12 col-xxl-10 col-xxxl-8 px-0">
        <div class="col-12 text-center">
            <p class="mb-0 py-4 h5">© Bébés Lutins 2020</p>
        </div>
    </div>

    <div class="row col-12 col-xxl-10 col-xxxl-8 py-3 px-0">
        @foreach (\App\FooterElement::all() as $footerElement)
        <div class="col-md-6 col-lg-3">
            <p class='h4 font-weight-bold'> {{ $footerElement->title }} </p>
            <ul class="list-unstyled">

                @foreach ($footerElement->contents as $content)
                <li><a class="mb-0" @if($content->url) href="{{ $content->url }}" @endif>
                    {{ $content->title }}</a></li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</footer>
