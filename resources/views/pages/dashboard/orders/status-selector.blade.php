<div class="form-group">
    <select class='custom-select'>
        <option value='0' @if($order->status == 0) selected @endif>En attente de paiement</option>
        <option value='1' @if($order->status == 1) selected @endif>En cours de traitement</option>
        <option value='2' @if($order->status == 2) selected @endif>En cours de livraison</option>

        <option value="22" @if($order->status == 22) selected @endif>A retirer à l'atelier</option>
        <option value="33" @if($order->status == 33) selected @endif>Participation enregistrée</option>
        <option value="3" @if($order->status == 3) selected @endif>Livrée</option>
        <option value="-1" @if($order->status == -1) selected @endif>Annulée</option>

        <option value='-3' @if($order->status == -3) selected @endif>Paiement refusé</option>
    </select>
</div>