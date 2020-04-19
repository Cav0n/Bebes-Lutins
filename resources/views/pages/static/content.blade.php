@extends('templates.default')

@section('title', $content->title . ' | Bébés Lutins')

@section('content')

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-9 col-lg-8 col-xl-7 col-xxl-6 col-xxxl-5 bg-white shadow-sm p-3">

                <h1>{{ $content->title }}</h1>

                @admin
                <a class="btn btn-dark mb-2" href="{{ route('admin.content.edit', ['content' => $content]) }}" role="button">Editer</a>
                @endadmin

                @foreach ($content->sections as $section)
                <h2 class="h4"> {{ $section->title }} </h2>
                <p class="text-justify">{!! $section->text !!}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
