@extends('templates.admin')

@section('content')

    @if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
    @endif

    <div class="card rounded-0 border shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">{{ isset($content) ? $content->title : 'Création d\'un produit' }}</h2>
        </div>
        <div class="card-body">
            <a href='{{ route('admin.contents') }}' class='text-dark'>< Contenus</a>
            <form method="post" action="{{ isset($content) ? route('admin.content.edit', ['content' => $content]) : route('admin.content.create') }}" >
                @csrf

                @foreach ($content->sections as $section)
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="helpTitle" value='{{ $section->title }}'>
                        <small id="helpTitle" class="form-text text-muted">Le titre de la section</small>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="text">Texte</label>
                        <textarea class="form-control" name="text" id="text" aria-describedby="helpText" rows='10'>{{ $section->text }}</textarea>
                        <small id="helpText" class="form-text text-muted">Le texte de la section</small>
                    </div>
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

@endsection
