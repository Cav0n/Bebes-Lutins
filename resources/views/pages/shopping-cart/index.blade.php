@extends('templates.template')

@section('content')
<main id='main-shopping-cart' class='container-fluid'>
    <div class="row justify-content-center py-5 bg-light">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            @if (count($shoppingCart->items) <= 0)
                <div class="card my-5 p-0 border rounded-0">
                    <div class="card-body border-0 row justify-content-center">
                        <h4 class="col-12 card-title text-center font-weight-bold">Votre panier est vide 😢</h4>
                        <p class="col-12 card-text text-center">Découvrez nos superbes articles !</p>
                        <div class='button-container d-flex justify-content-center col-6'>
                            <a name="discover-button" id="discover-button" class="btn btn-secondary text-center w-100" href="/" role="button">Découvrir</a>
                        </div>
                    </div>
                </div>
            @else
                no
            @endif
        </div>
    </div>
</main>


@endsection