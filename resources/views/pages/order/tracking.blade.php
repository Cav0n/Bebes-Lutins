@extends('templates.default')

@section('title', "Suivi de commande - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8 col-xxl-6 col-xxxl-5">
            <h1 class="h1 font-weight-bold">
                Suivi de commande
            </h1>

            <div class="form-group">
              <label for="search">Numéro de suivi</label>
              <div class="input-group mb-3">
                <input type="text" id="search" name="search" class="form-control">
                <div class="input-group-append">
                    <button id='track-btn' class="input-group-text btn">Chercher</button>
                </div>
              </div>
            </div>

            <div class="tracking-result">

            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        var trackingNumber = "";

        $('#track-btn').on('click', function(){
            trackingNumber = $('#search').val();

            fetch('/api/order/tracking/' + trackingNumber)
            .then(res => res.json())
            .then(response => {
                if (response.order) {
                    $('.tracking-result').html(response.order);
                    return;
                }

                $('.tracking-result').text("Aucune commande trouvée avec ce numéro.");
            });
        });
    </script>
@endsection
