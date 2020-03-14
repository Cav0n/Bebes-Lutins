@extends('templates.default')

@section('title', "Suivi de commande - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5">
            <h1 class="h1 font-weight-bold">
                Suivi de commande
            </h1>

            <div class="form-group">
              <label for="search">Numéro de suivi</label>
              <div id="search-input-container" class="input-group mb-3">
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
        var trackingNumber = null;
        var errorFeedbackHtml = "<div class='invalid-feedback'>__error__</div>"

        $('#track-btn').on('click', function(){
            let search = $('#search');
            let searchInputContainer = $('#search-input-container');

            $('.invalid-feedback').remove();
            search.removeClass('is-invalid');
            $('.tracking-result').empty();

            if (0 === search.val().length) {
                search.addClass('is-invalid');
                searchInputContainer.append(errorFeedbackHtml.replace('__error__', "Vous devez entrez votre numéro de suivi."));
                return;
            }

            fetch("/api/order/tracking/" + search.val())
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.error){
                    throw response.error;
                }

                $('.tracking-result').html(response.order);
            }).catch((error) => {
                search.addClass('is-invalid');
                searchInputContainer.append(errorFeedbackHtml.replace('__error__', error.message));
            });
        });
    </script>
@endsection
