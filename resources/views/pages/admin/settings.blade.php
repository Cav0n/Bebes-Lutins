@extends('templates.admin')

@section('content')

@if(Session::get('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('successMessage') }}
    </div>
@endisset

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Paramètres</h2>
    </div>
    <form class="card-body" method="POST" action="{{ route('admin.settings.save') }}">
        @csrf
        @foreach ($settings as $setting)
            @include('components.utils.settings.setting')
        @endforeach

        <a class="btn btn-danger" href="{{ route('admin.sitemap.reload') }}" role="button">Regenérer sitemap.xml</a>

        <button type="submit" class="btn btn-outline-dark">Sauvegarder</button>
    </div>
</div>

@endsection
