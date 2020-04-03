@extends('templates.admin')

@section('content')

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">Paramètres</h2>
    </div>
    <div class="card-body">
        @foreach ($settings as $setting)
            <p>
                {{ $setting->key }} : {{ $setting->value }}
            </p>
        @endforeach
    </div>
</div>

@endsection
