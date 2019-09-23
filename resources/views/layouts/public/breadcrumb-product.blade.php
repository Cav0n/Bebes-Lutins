<span id='breadcrumb'>
    <a href='/'>Accueil</a>
    
    @if($category->name != null)
        @foreach ($category->generateBreadcrumb() as $item)
            / <a href='/categories/{{$item->id}}'>{{$item->name}}</a>
        @endforeach
        / <a href='/produits/{{$product->id}}'>{{$product->name}}</a>
    @else
        / <a href='/produits'>Nos produits</a> / <a href='/produits/{{$product->id}}'>{{$product->name}}</a>
    @endif
    
</span>