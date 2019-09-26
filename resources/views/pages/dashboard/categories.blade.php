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
                <tr class='d-flex'>
                    <th class='border-top-0 col-2'></th>
                    <th class='border-top-0 col-8'>Nom</th>
                    <th class='border-top-0 text-center col-2'>Caché</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Category::where('parent_id', null)->orderBy('rank')->get() as $category)
                    <tr class='d-flex clickable @if($category->isHidden){{'hidden'}}@endif' data-toggle="collapse" data-target=".accordion-{{$category->id}}" class="clickable">
                        <td class='col-2'>
                            <div class="form-group">
                                <input type="number" min='0' step='1' class="form-control" name="rank" id="rank" aria-describedby="helpRank" placeholder="0" value='{{$category->rank}}' onchange='update_rank(this.value, "{{$category->id}}")')>
                            </div>
                        </td>
                        <td class='col-8' scope="row">{{$category->name}}</td>
                        <td class='col-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$category->id}}")' @if($category->isHidden) {{'checked'}} @endif></div></td>
                    </tr>
                    
                    @foreach ($category->childs as $child)
                    <tr class='accordion-{{$category->id}} collapse justify-content-center @if($child->isHidden){{'hidden'}}@endif'>
                        <td class='col-1'>

                        </td>
                        <td class='col-2'>
                            <div class="form-group">
                                <input type="number" min='0' step='1' class="form-control" name="rank" id="rank" aria-describedby="helpRank" placeholder="0" value='{{$child->rank}}' onchange='update_rank(this.value, "{{$child->id}}")'>
                            </div>
                        </td>
                        <td class='col-7'>{{$child->name}}</td>
                        <td class='col-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$child->id}}")' @if($child->isHidden) {{'checked'}} @endif></div></td>
                    </tr>
                    @endforeach
                
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function update_rank(new_rank, category_id){
    $.ajax({
        url: "/dashboard/produits/categories/rang/"+category_id+"/"+new_rank,
        beforeSend: function() {
            init_loading();
        }
    })
    .done(function( data ) {
        stop_loading();
        window.location.href='/dashboard/produits/categories'
    });
}
</script>

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

<script>
$('.collapse').on('show.bs.collapse', function () {
  $(this).addClass('d-flex');
})

$('.collapse').on('hidden.bs.collapse', function () {
    $(this).removeClass('d-flex');
})
</script>
@endsection