@extends('templates.default')

@section('title', "Mes commandes | Espace client - Bébés Lutins")

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 card p-0">

            @include('components.customer_area.title')

            <div class="body p-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="h4 font-weight-bold">Mes commandes</h3>
                        @foreach (Auth::user()->orders as $order)
                            @include('components.utils.orders.order', ['order' => $order])
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer border-bottom p-3">
                <a href="{{route('logout')}}" class="mb-0 text-dark">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

@endsection
