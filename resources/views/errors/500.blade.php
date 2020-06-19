@extends('templates.default')

@section('title', '500 - Bébés Lutins')

@section('content')

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-xxxl-6 col-xl-8 col-lg-9 col-md-10 d-flex flex-column flex-md-row justify-content-center">

            <div class="d-flex flex-column justify-content-center text-center text-md-right">
                <h1 class="big-error-code">500</h1>
                <p class="mb-0">Une erreur est survenu lors du traitement de votre demande nous en sommes désolé...</p>
            </div>
            <div class="m-0 w-100">
                <img src="{{asset('images/svg/404.svg')}}" alt="404">
            </div>

        </div>
    </div>
</div>
@endsection
