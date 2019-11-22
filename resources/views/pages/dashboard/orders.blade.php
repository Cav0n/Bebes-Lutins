@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Commandes @if($status != null) {{$status}} @endif
        </h1>
    </div>
    <div class="card-body">
        
        @include('components.dashboard.search-bar')

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

@include('components.public.popups.order-status-change');

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function(){
        previous = "";
        $("select").on('focus', function () {
            previous = this.value;
        })

        $('.status-selector').on('change', function (e) {
            var new_status = parseInt(this.value);
            var order_id = $(this).attr('id').replace('select-for-', '');

            get_order(order_id, new_status);
        });

        $('#order-status-change-modal').on('hide.bs.modal', function (e) {
            order_id = $('#hidden_order_id').val();
            $('#select-for-' + order_id).val(previous).change();

        })
    });
</script>

{{-- AJAX GET ORDER --}}
<script>
    function get_order(order_id, new_status){
        $.ajax({
            url: '/commandes/' + order_id,
            type: 'POST',
            data: { },
            async: false, // TO GET ORDER RETURN
            success: function(response){
                show_order_status_change_modal(response.order, new_status)
            }
        });
    }
</script>

{{-- SHOW ORDER STATUT MODAL --}}
<script>
    function show_order_status_change_modal(order, new_status){
        date = order.created_at.replace(/[ ]([0-9]+[:]+)+[0-9]+/, '');
        date = new Date(date).toLocaleDateString();

        $('#message').html(`
            Vous allez modifier la commande de ` + order.user.firstname + ` ` + order.user.lastname + ` du ` + date + `.<BR>
            <BR>
            Ancien statut : <b>`+ status_to_string(order.status) +`</b><BR>
            Nouveau statut : <b class='text-danger'>`+ status_to_string(new_status) +`</b>
        `);

        $('#hidden_order_id').val(order.id);
        $('#hidden_new_status').val(new_status);

        $('#order-status-change-modal').modal('show');
    }
</script>

{{-- STATUS TO STRING --}}
<script>
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