<div class="row">
    <div class="col-12">
        <p>
            <a class="font-weight-light text-dark small mx-2" href='/'>Accueil</a>
            @foreach ($category->generateBreadcrumb() as $item)
                / <a class="font-weight-light text-dark small mx-2" href='/categories/{{$item->id}}'>{{$item->name}}</a>
            @endforeach
        </p>
    </div>
</div>