<span id='breadcrumb'>
    <a class='font-weight-light text-dark small mx-2' href='/'>Accueil</a>
    
    @if(isset($category->name))
        @foreach ($category->generateBreadcrumb() as $item)
            / <a href='/categories/{{$item->id}}' class='text-dark font-weight-light small mx-2'>{{$item->name}}</a>
        @endforeach
        / <a href='/produits/{{$product->id}}' class='text-dark font-weight-light small mx-2'>{{$product->name}}</a>
    @else
        / <a href='/produits' class='text-dark font-weight-light small mx-2'>Nos produits</a> / <a href='/produits/{{$product->id}}' class='text-dark font-weight-light small mx-2'>{{$product->name}}</a>
    @endif
    
</span>