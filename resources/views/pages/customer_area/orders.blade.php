@extends('templates.default')

@section('title', "Mes commandes | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0 border-0 rounded-0 shadow-sm">

            @include('components.customer_area.title')

            <div class="body p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes commandes</h3>
                        @if (count($orders) <= 0)

                        <p class="mb-0">Vous n'avez passé aucune commande sur le site.</p>

                        @else

                        @foreach ($orders as $order)
                            @include('components.utils.orders.mini', ['order' => $order])
                        @endforeach

                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        </div>

                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer rounded-0 bg-white p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection
