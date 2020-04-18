@extends('templates.default')

@section('title', "Suivi de commande - Bébés Lutins")

@section('optional_css')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css"/>
@endsection

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5">
            <h1 class="h1 font-weight-bold">
                Suivi de commande
            </h1>

            <div class="form-group">
              <label for="search">Numéro de suivi</label>
              <div id="search-input-container" class="input-group mb-3 ld-over">
                <input type="text" id="search" name="search" class="form-control">
                <div class="input-group-append">
                    <button id='track-btn' class="input-group-text btn">Chercher</button>
                </div>
                <div class="ld ld-ring ld-spin"></div>
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
            searchInputContainer.addClass('running');

            $('.invalid-feedback').remove();
            search.removeClass('is-invalid');
            $('.tracking-result').empty();

            if (0 === search.val().length) {
                search.addClass('is-invalid');
                searchInputContainer.append(errorFeedbackHtml.replace('__error__', "Vous devez entrez votre numéro de suivi."));
                searchInputContainer.removeClass('running');

                return;
            }

            fetch("/api/order/tracking/" + search.val())
            .then(response => response.json())
            .then(response => {
                if (undefined !== response.error){
                    throw response.error;
                }

                $('.tracking-result').html(response.order);
                searchInputContainer.removeClass('running');
            }).catch((error) => {
                search.addClass('is-invalid');
                searchInputContainer.append(errorFeedbackHtml.replace('__error__', error.message));
                searchInputContainer.removeClass('running');
            });
        });
    </script>
@endsection
