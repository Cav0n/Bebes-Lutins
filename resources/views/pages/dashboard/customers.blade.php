@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Clients
        </h1>
    </div>
    <div class="card-body">

        @include('components.dashboard.search-bar')

        <div id='customers-container'>
            {{$users->links()}}
            <table class="table" style=''>
                <thead>
                    <tr>
                        <th class='border-top-0'>Nom</th>
                        <th class='d-none d-sm-table-cell border-top-0'>Email</th>
                        <th class='d-none d-md-table-cell border-top-0'>Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr onclick='load_url("/dashboard/clients/fiche/{{$user->id}}")'>
                        <td class=''><b>{{$user->firstname}} {{$user->lastname}}</b></td>
                        <td class='d-none d-sm-table-cell'>{{mb_strtolower($user->email)}}</td>
                        <td class='d-none d-md-table-cell'>{{chunk_split($user->phone, 2, ' ')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id='search-container'>
            <h2 id='result-title' class='h4'>Résultats</h2>
            <table class="table">
                <thead>
                    <tr class='d-flex'>
                        <th class='border-top-0 col-3'>Nom</th>
                        <th class='border-top-0 col-6'>Email</th>
                        <th class='border-top-0 col-3'>Téléphone</th>
                    </tr>
                </thead>
                <tbody id='search-table-body'>

                </tbody>
            </table>
            <h2 class='h4 mt-3'>Autres résultats</h2>
            <table class="table">
                <thead>
                    <tr class='d-flex'>
                        <th class='border-top-0 col-3'>Nom</th>
                        <th class='border-top-0 col-6'>Email</th>
                        <th class='border-top-0 col-3'>Téléphone</th>
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

    $("#customers-container").show();
    $("#search-container").hide();

    $("#search-bar").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });
            
    function search(){
        search_words = $("#search-bar").val();
        button = $("#search-button");

        if(search_words != ""){
            $.ajax({
                url : '/dashboard/clients/recherche', // on appelle le script JSON
                type: "POST",
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data : {
                    search: search_words
                },
                beforeSend: function(){
                    button.addClass('running');
                },
                success : function(data){
                    $("#customers-container").hide();
                    $("#search-container").show();
                    $("#search-table-body").empty();
                    $("#search-possible-table-body").empty();

                    $.each(data.valid_customers, function(index, customer){
                        console.log(customer);
                        customer_html = `
                        <tr class='d-flex' onclick='load_url("/dashboard/clients/fiche/`+customer.id+`")'>
                            <td class='col-3'><b>`+customer.firstname+` `+customer.lastname+`</b></td>
                            <td class='col-6'>`+customer.email.toLowerCase()+`</td>
                            <td class='col-3'>`+customer.phone+`</td>
                        </tr>`

                        $("#search-table-body").append(customer_html);
                    });

                    $.each(data.possible_customers, function(index, customer){
                        console.log(customer);
                        customer_html = `
                        <tr class='d-flex' onclick='load_url("/dashboard/clients/fiche/`+customer.id+`")'>
                            <td class='col-3'><b>`+customer.firstname+` `+customer.lastname+`</b></td>
                            <td class='col-6'>`+customer.email.toLowerCase()+`</td>
                            <td class='col-3'>`+customer.phone+`</td>
                        </tr>`

                        $("#search-possible-table-body").append(customer_html);
                    });

                    $('#result-title').text("Résultats ("+data.valid_results_nb+" clients)");

                    button.removeClass('running');
                }
            });
        } else {
            $("#customers-container").show();
            $("#search-container").hide();
        }
    }
</script>
@endsection