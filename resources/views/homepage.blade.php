@extends('templates.template')

@section('head-options')
    {{-- Swiper JS --}}
    <script src="{{asset('js/swiper/swiper.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/swiper/swiper.css')}}">
@endsection

@section('content')
<main class='container-fluid'>
    <div class="row">
        @include('layouts.public.main-swiper')
    </div>
</main>
@endsection