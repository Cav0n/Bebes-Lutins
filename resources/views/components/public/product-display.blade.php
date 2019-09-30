<?php $firstThumbnail = $product->images->first(); ?>
<div class="col-6 col-sm-4 col-md-4 col-lg-3 mb-3">
    <div class="card product m-0 h-100 transition-fast rounded-0 border-0" style='font-size:0.9rem;'>
        <div class='images-container border @if($firstThumbnail == null) no-thumbnails @endif' onclick='load_url("/produits/{{$product->id}}")'>
            <img class="card-img-top main-image h-100 rounded-0" src="{{asset('images/products/'.$product->mainImage)}}" alt="{{$product->name}}" title="{{$product->name}}">
            @if($firstThumbnail != null)<img class='card-img-top thumbnail d-none h-100 rounded-0' src="{{asset('images/products/thumbnails/'.$firstThumbnail['name'])}}">@endif
        </div>
        <div class="card-body border-left border-right" onclick='load_url("/produits/{{$product->id}}")'>
            <p class="card-text">{{$product->name}}</p>
        </div>
        <div class='card-footer text-muted d-flex px-0 py-1 border'>
            <p class='mb-0 w-100 text-center'>{{$product->price}}€</p>
        </div>
        <div class="card-footer text-muted d-none d-sm-flex p-0 rounded-0 border-0">
            <button type="button" class="btn btn-secondary h-100 w-100 px-0 py-2 rounded-0" onclick='add_to_cart("{{$product->id}}", "{{$product->name}}", "{{session("shopping_cart")->id}}")' style='font-size:0.9rem !important;'>Ajouter au panier</button> 
        </div>
    </div> 
</div>
