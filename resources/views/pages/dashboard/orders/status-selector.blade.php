<div class="form-group mb-0 ld-over">
    <select class='custom-select' onchange="change_order_status($(this), '{{$order->id}}')">
        <option value='0' @if($order->status == 0) selected @endif>En attente de paiement</option>
        <option value='1' @if($order->status == 1) selected @endif>En cours de traitement</option>
        <option value='2' @if($order->status == 2) selected @endif>En cours de livraison</option>

        <option value="22" @if($order->status == 22) selected @endif>A retirer à l'atelier</option>
        <option value="33" @if($order->status == 33) selected @endif>Participation enregistrée</option>
        <option value="3" @if($order->status == 3) selected @endif>Livrée</option>
        <option value="-1" @if($order->status == -1) selected @endif>Annulée</option>

        <option value='-3' @if($order->status == -3) selected @endif>Paiement refusé</option>
    </select>
    <div class="ld ld-ring ld-spin"></div>
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