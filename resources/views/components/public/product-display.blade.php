<?php $firstThumbnail = $product->images->skip(1)->first(); ?>
<div class="col-6 col-sm-4 col-md-4 col-lg-3 mb-3" @if($product->stock <= 0) style='opacity:0.7;' @endif>
    <div class="card product m-0 h-100 transition-fast rounded-0 border-0" style='font-size:0.9rem;'>
        <div class='images-container border @if($firstThumbnail == null) no-thumbnails @endif' @if($product->stock > 0) onclick='load_url("/produits/{{$product->id}}")' @endif>
            <img class="card-img-top main-image h-100 rounded-0" src="{{asset('images/products/'.$product->mainImage)}}" alt="{{$product->name}}" title="{{$product->name}}">
            @if($firstThumbnail != null)<img class='card-img-top thumbnail d-none h-100 rounded-0' src="{{asset('images/products/thumbnails/'.$firstThumbnail['name'])}}">
            @else <img class="card-img-top thumbnail d-none h-100 rounded-0" src="{{asset('images/products/'.$product->mainImage)}}">
            @endif
        </div>
        <div class="card-body border-left border-right" @if($product->stock > 0) onclick='load_url("/produits/{{$product->id}}")' @endif>
            <p class="card-text">{{$product->name}}</p>
        </div>
        <div class='card-footer text-muted d-flex px-0 py-1 border' @if($product->stock > 0) onclick='load_url("/produits/{{$product->id}}")' @endif>
            <p class='mb-0 w-100 text-center'>{{$product->price}}€</p>
        </div>
        <div class="card-footer text-muted d-none d-sm-flex p-0 rounded-0 border-0">
        <button type="button" class="btn btn-secondary h-100 w-100 px-0 py-2 rounded-0"
        @if($product->stock > 0) 
        @if(count($product->characteristics) == 0) onclick='add_to_cart("{{$product->id}}", "{{$product->name}}", {{$product->price}}, "{{$product->mainImage}}", "{{$product->stock}}", "{{session("shopping_cart")->id}}")'
        @else onclick='load_url("/produits/{{$product->id}}")'
        @endif
        @endif style='font-size:0.9rem !important;' @if($product->stock <= 0) disabled @endif>
            @if($product->stock > 0)
            @if(count($product->characteristics) == 0) Ajouter au panier
            @else Voir le produit
            @endif
            @else Rupture de stock
            @endif
        </button> 
        </div>
    </div> 
</div>
