@extends('templates.dashboard')

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/produits' class='text-muted'>< Tous les produits</a>        
    </div>
</div>

 @if(count($categoriesWithMissingMainImage) > 0)
<div class="card bg-warning my-3">
    <div class="card-header bg-warning d-flex">
        <h1 class='h4 m-0 my-auto font-weight-normal'>
            Certaines catégories ont des problèmes d'images !
        </h1>
    </div>
    <div class="card-body">
        <ul>
            @foreach ($categoriesWithMissingMainImage as $category)
            <li class='text-muted'>
                <a href='/dashboard/produits/categories/edition/{{$category->id}}' class='text-muted'>
                    {{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif 

<div class="card bg-white my-3">
    <div class="card-header bg-white d-flex">
        <h1 class='h4 my-auto m-0 font-weight-normal'>
            Catégories
        </h1>
        <a name="btn-creation" id="btn-creation" class="btn btn-outline-secondary border-0 ml-auto" href="/dashboard/produits/categories/nouvelle" role="button">Nouveau</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher une catégorie" aria-describedby="helpSearch">
                </div>
            </div>
            <div class="col-3">
                <button type="submit" id="search-button" class="btn btn-secondary w-100 border-light ld-over" onclick='search_category()'>
                    Rechercher <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
        </div>
        <div id='categories-container'>
            <table class="table">
                <thead>
                    <tr class='d-flex'>
                        <th class='border-top-0 col-4 col-md-2'></th>
                        <th class='border-top-0 col-8'>Nom</th>
                        <th class='border-top-0 text-center d-none col-md-2'>Caché</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class='d-flex clickable @if($category->isHidden){{'hidden'}}@endif' data-toggle="collapse" data-target=".accordion-{{$category->id}}" class="clickable">
                            <td class='col-4 col-md-2'>
                                <div class="form-group">
                                    <input type="number" min='0' step='1' class="form-control" name="rank" id="rank" aria-describedby="helpRank" placeholder="0" value='{{$category->rank}}' onchange='update_rank(this.value, "{{$category->id}}")')>
                                </div>
                            </td>
                            <td class='col-8' scope="row"><a href='/dashboard/produits/categories/edition/{{$category->id}}' class='max-content text-dark'>{{$category->name}}</a></td>
                            <td class='d-none col-md-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$category->id}}")' @if($category->isHidden) {{'checked'}} @endif></div></td>
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
                            <td class='col-7'><a href='/dashboard/produits/categories/edition/{{$child->id}}' class='max-content text-dark'>{{$child->name}}</a></td>
                            <td class='col-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "{{$child->id}}")' @if($child->isHidden) {{'checked'}} @endif></div></td>
                        </tr>
                        @endforeach
                    
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id='search-container'>
            <h2 class='h4'>Résultats</h2>
            <table class="table">
                <thead>
                    <tr class='d-flex'>
                        <th class='border-top-0 col-2'></th>
                        <th class='border-top-0 col-8'>Nom</th>
                        <th class='border-top-0 text-center d-none col-2'>Caché</th>
                    </tr>
                </thead>
                <tbody id='search-table-body'>

                </tbody>
            </table>
            <h2 class='h4 mt-3'>Autres résultats</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class='border-top-0 col-4 col-md-2'></th>
                        <th class='border-top-0 col-8'>Nom</th>
                        <th class='border-top-0 text-center d-none col-md-2'>Caché</th>
                    </tr>
                </thead>
                <tbody id='search-possible-table-body'>

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PREPARE AJAX --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
        

{{-- SEARCH PRODUCT AJAX --}}
<script>

    $("#categories-container").show();
    $("#search-container").hide();

    $("#search-bar").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });
            
    function search_category(){
        search = $("#search-bar").val();
        button = $("#search-button");

        if(search != ""){
            $.ajax({
                url : '/dashboard/categories/recherche', // on appelle le script JSON
                type: "POST",
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data : {
                    search: search
                },
                beforeSend: function(){
                    button.addClass('running');
                },
                success : function(data){
                    $("#categories-container").hide();
                    $("#search-container").show();
                    $("#search-table-body").empty();
                    $("#search-possible-table-body").empty();

                    $.each(data.valid_categories, function(index, category){
                        console.log(category);
                        category_html = `
                        <tr class='d-flex'>
                            <td class='col-4 col-md-2'>
                                <div class="form-group">
                                    <input type="number" min='0' step='1' class="form-control" name="rank" id="rank" aria-describedby="helpRank" placeholder="0" value='`+category.rank+`' onchange='update_rank(this.value, "`+category.id+`")')>
                                </div>
                            </td>
                            <td class='col-8' scope="row"><a href='/dashboard/produits/categories/edition/`+category.id+`' class='max-content text-dark'>`+category.name+`</a></td>
                            <td class='d-none col-md-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "`+category.id+`")' checked></div></td>
                        </tr>`;

                        if(category.isHidden == 0) category_html.replace('checked', '');

                        $("#search-table-body").append(category_html);
                    });

                    $.each(data.possible_categories, function(index, category){
                        console.log(category);
                        category_html = `
                        <tr class='d-flex'>
                            <td class='col-4 col-md-2'>
                                <div class="form-group">
                                    <input type="number" min='0' step='1' class="form-control" name="rank" id="rank" aria-describedby="helpRank" placeholder="0" value='`+category.rank+`' onchange='update_rank(this.value, "`+category.id+`")')>
                                </div>
                            </td>
                            <td class='col-8' scope="row"><a href='/dashboard/produits/categories/edition/`+category.id+`' class='max-content text-dark'>`+category.name+`</a></td>
                            <td class='d-none col-md-2 text-center'><div class="form-group"><input type="checkbox" class="form-check-input ml-auto" name="" id="" onclick='switch_isHidden($(this), "`+category.id+`")' checked></div></td>
                        </tr>`;

                        if(category.isHidden == 0) category_html.replace('checked', '');

                        $("#search-possible-table-body").append(category_html);
                    });

                    button.removeClass('running');
                }
            });
        } else {
            $("#categories-container").show();
            $("#search-container").hide();
        }
    }
</script>

<script>
function update_rank(new_rank, category_id){
    $.ajax({
        url: "/dashboard/produits/categories/rang/"+category_id+"/"+new_rank,
        beforeSend: function() {
            init_loading();
        }
    })
    .done(function( data ) {
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
        checkbox.parent().parent().parent().toggleClass('hidden');
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