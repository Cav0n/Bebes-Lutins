@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white d-flex">
        <h1 class='h4 my-auto m-0 font-weight-normal'>
            Catégories
        </h1>
        <a name="btn-creation" id="btn-creation" class="btn btn-primary border-light ml-auto" href="/dashboard/produits/categories/nouveau" role="button">Nouveau</a>
    </div>
    <div class="card-body">
        <form action="/dashboard/produits/recherche" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher une catégorie" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100 border-light">Rechercher</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Nom</th>
                    <th class='border-top-0 text-center'>Caché</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Category::where('parent_id', null)->get() as $category)
                    <tr class='clickable @if($category->isHidden){{'hidden'}}@endif' data-toggle="collapse" data-target=".accordion-{{$category->id}}" class="clickable">
                        <td scope="row">{{$category->name}}</td>
                        <td class='text-center'><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$category->id}}")' @if($category->isHidden) {{'checked'}} @endif></td>
                    </tr>
                    
                    @foreach ($category->childs as $child)
                    <tr class='accordion-{{$category->id}} collapse'>
                        <td>
                            <div class="pl-4">{{$child->name}}</div>
                            <td class='text-center'><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$child->id}}")' @if($child->isHidden) {{'checked'}} @endif></td>
                        </td>
                    </tr>
                    @endforeach
                
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
        function switch_isHidden(checkbox, category_id){
            $.ajax({
                url: "/dashboard/switch_is_hidden_category/"+category_id,
                beforeSend: function() {
                    init_loading();
                }
            })
            .done(function( data ) {
                stop_loading();
                checkbox.parent().parent().toggleClass('hidden');
            });
            
        }
        </script>
@endsection