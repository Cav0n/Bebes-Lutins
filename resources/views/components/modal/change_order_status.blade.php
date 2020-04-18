 <div class="modal fade" id="change-status-modal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModal" aria-hidden="true"
    data-select-id="{{ $selectId }}"
    data-order-id="{{ $order->id }}"
    data-old-status="{{ $order->status }}"
    data-new-status="{{ $newOrder->status }}" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Changement de status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir changer le status de la commande <b>{{ $order->trackingNumber }}</b> de
                {{ ucfirst($order->billingAddress->minCivilityI18n) . ' ' . $order->billingAddress->firstname . ' ' . $order->billingAddress->lastname }} ? <br>
                <br>
                Status actuel : {!! $order->statusTag !!} <br>
                Status à appliquer : {!! $newOrder->statusTag !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Non</button>
                <button type="button" class="btn btn-success change-status-validation-btn" data-mail="1">
                    Oui</button>
                <button type="button" class="btn btn-success change-status-validation-btn" data-mail="0">
                    Oui sans envoi d'email</button>
            </div>
        </div>
    </div>

    <script>
        $('#change-status-modal').modal('show');

        $('#change-status-modal').on('hidden.bs.modal', function () {
            let selectId = $(this).data('select-id');
            let oldStatus = $(this).data('old-status')

            $('#' + selectId).val(oldStatus);
        });

        $('.change-status-validation-btn').on('click', function() {
            updateOrder(
                $('#' + $('#change-status-modal').data('select-id')),
                $('#change-status-modal').data('order-id'),
                $('#change-status-modal').data('new-status'),
                $(this).data('mail')
            )
        });

        function updateOrder(select, orderId, status, mail = 1) {
                fetch("/api/order/" + orderId + "/status/update", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        order: orderId,
                        status: status,
                        mail
                    })
                })
                    .then(response => response.json())
                    .then(response => {
                        if (undefined !== response.errors){
                            throw response.errors;
                        }

                        select.css('background-color', response.color);
                        location.reload();
                    }).catch((errors) => {
                    select.addClass('is-invalid');
                    errors.status.forEach(message => {
                        select.after(errorFeedbackHtml.replace('__error__', message));
                    });
                });
            }
    </script>

</div>
