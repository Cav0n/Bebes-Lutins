<div id='order-status-change-modal' class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Changement de status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input id='hidden_order_id' type="hidden" name="order_id">
            <input id='hidden_new_status' type="hidden" name="new_status">
            <p class='mb-0' id='message'></p>
            <br>
            <div class="custom-control custom-checkbox noselect">
                <input type="checkbox" class="custom-control-input" id="dont-notify-customer" name="dont-notify-customer">
                <label class="custom-control-label" for="dont-notify-customer">Ne pas notifier le client</label>
            </div>
        </div>
        <div class="modal-footer flex-wrap">
            <button id='cancel-order-status' type="button" class="mr-auto mb-2 mb-sm-0 btn btn-outline-danger rounded-0" data-dismiss="modal">
                Annuler</button>
            <button id='apply-order-status' type="button" class="btn btn-secondary rounded-0 mb-2 mb-sm-0 ld-ext-right">
                Mettre à jour <div class='ld ld-ring ld-spin'></div></button>
        </div>
    </div>
</div>

{{-- PREPARE BUTTON --}}
<script>
    $('#apply-order-status').on('click', function(){
        $(this).addClass('running');

        order_id = $('#hidden_order_id').val();
        new_status = $('#hidden_new_status').val();
        notify_customer = !$('#dont-notify-customer').prop("checked");
        // console.log(notify_customer);

        $.ajax({
            url: "/dashboard/commandes/changer_status/" + order_id,
            type: 'POST',
            data: { status: new_status, notify_customer:notify_customer },
            success: function(response){
                // console.log(response);
                location.reload();
            },
            beforeSend: function() {
                $(this).addClass('running');
            }, 
        });
    });
</script>