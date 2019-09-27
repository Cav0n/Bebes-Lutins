
<?php $firstThumbnail = $product->images->first(); ?>
<?php echo public_path() . '/images/products/' . $product->mainImage; ?>
@if (File::exists(public_path() . '/images/products/' . $product->mainImage))
    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
    <div class="card product my-2 transition-fast">
        <div class='images-container @if($firstThumbnail == null) no-thumbnails @endif' onclick='load_url("/produits/{{$product->id}}")'>
            <img class="card-img-top main-image h-100" src="{{asset('images/products/'.$product->mainImage)}}" alt="{{$product->name}}" title="{{$product->name}}">
            @if($firstThumbnail != null)<img class='card-img-top thumbnail d-none h-100' src="{{asset('images/products/thumbnails/'.$firstThumbnail['name'])}}">@endif
        </div>
        <div class="card-body" onclick='load_url("/produits/{{$product->id}}")'>
            <p class="card-text">{{$product->name}}</p>
            <p class='mb-0'>{{$product->price}}€</p>
        </div>
        <div class="card-footer text-muted d-flex p-0 rounded-0">
            <button type="button" class="btn btn-secondary h-100 w-100 px-0 py-2 rounded-0" onclick='add_to_cart("{{$product->id}}", "{{$product->name}}")'>Ajouter au panier</button> 
        </div>
    </div> 
</div>
@endif
