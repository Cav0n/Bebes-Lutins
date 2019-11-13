@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Commandes @if($status != null) {{$status}} @endif
        </h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher une commande" aria-describedby="helpSearch">
                </div>
            </div>
            <div class="col-3">
                <button type="button" id="search-button" class="btn btn-secondary w-100 border-light ld-over" onclick='search_order()'>
                    Rechercher  <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
        </div>
        @switch($status)
            @case(null)
                @include('pages.dashboard.orders.all')
                @break
            @case('en cours')
                @include('pages.dashboard.orders.being-processed')
                @break
            @case('terminées')
                @include('pages.dashboard.orders.ended')
                @break
            @case('refusées')
                @include('pages.dashboard.orders.refused')
                @break
        @endswitch
        @include('pages.dashboard.orders.search-result')
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function change_order_status(select, order_id){
        var order = null;
        new_status = select.find(":selected").text();

        $.ajax({
            url: "/commandes/" + order_id,
            type: 'POST',
            data: { },
            async: false, // TO GET ORDER RETURN
            success: function(data){
                order = $.parseJSON(data).order;
            }
        });

        if(confirm("Vous avez choisis de modifier la commande de "+ order.user.firstname +" "+ order.user.lastname +", passée le "+order.created_at+", d'une valeur de "+order.products_price+"€.\nAncien status : "+status_to_string(order.status)+"\nNouveau status : "+new_status)){
            $.ajax({
                url: "/dashboard/commandes/changer_status/" + order_id,
                type: 'POST',
                data: { status: select.val() },
                success: function(data){
                    console.log('Status bien modifié !');
                    location.reload();
                },
                beforeSend: function() {
                    select.parent().addClass('running');
                }
            });
        }
    }

    function status_to_string(status){
        switch(status){
            case 0:
                return 'En attente de paiement';
                break;

            case 1:
                return 'En cours de traitement';
                break;

            case 2:
                return 'En cours de livraison';
                break;

            case 22:
                return 'Prête à l\'atelier';
                break;

            case 3:
                return 'Livrée';
                break;

            case 33:
                return 'Participation enregistrée';
                break;

            case -1:
                return 'Annulée';
                break;

            case -2:
                return 'Vérification bancaire';
                break;

            case -3:
                return 'Paiement refusé';
                break;

            default:
                return 'Problème de mise à jour';
                break;
        }    
    }
</script>
@endsection