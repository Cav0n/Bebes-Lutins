<span id='breadcrumb'>
    / <a href='/' class='text-dark'>Accueil</a>
    
    @if(isset($category->name))
        @foreach ($category->generateBreadcrumb() as $item)
            / <a href='/categories/{{$item->id}}' class='text-dark'>{{$item->name}}</a>
        @endforeach
        / <a href='/produits/{{$product->id}}' class='text-dark'>{{$product->name}}</a>
    @else
        / <a href='/produits' class='text-dark'>Nos produits</a> / <a href='/produits/{{$product->id}}' class='text-dark'>{{$product->name}}</a>
    @endif
    
</span>