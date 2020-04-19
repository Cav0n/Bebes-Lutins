@extends('templates.admin')

@section('optional_js')
<script src="https://cdn.tiny.cloud/1/o3xxn1egstud8k4clezmtiocupaj5kof1ox4k1ywocrgml58/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content')

    @if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
    @endif

    <div class="row justify-content-between mx-0">
        <a class="btn btn-dark mb-3" href="{{ route('admin.contents') }}" role="button">
            < Contenus</a>

        @if(isset($content) && "CONTENT" === $content->type) <a class="btn btn-outline-secondary" href="{{ route('content.show', ['content' => $content]) }}" role="button">
            Voir le contenu</a> @endif
    </div>

    @if(!empty($errors->any()))
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
            <p class="mb-0">{{ ucfirst($error) }}</p>
            @endforeach
        </div>
    @endif

    <div class="card rounded-0 border shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">{{ isset($content) ? $content->title : 'Création d\'un produit' }}</h2>
        </div>
        <div class="card-body">
            <form method="post" action="{{ isset($content) ? route('admin.content.edit', ['content' => $content]) : route('admin.content.create') }}" >
                @csrf

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="type">Type de contenu</label>
                            <select id="type" class="custom-select" name="type">
                                <option value="CONTENT" {{ 'CONTENT' == $content->type ? 'selected' : null }}>
                                    Contenu</option>
                                <option value="LINK" {{ 'LINK' == $content->type ? 'selected' : null }}>
                                    Lien</option>
                                <option value="TEL" {{ 'TEL' == $content->type ? 'selected' : null }}>
                                    Téléphone de contact</option>
                                <option value="EMAIL" {{ 'EMAIL' == $content->type ? 'selected' : null }}>
                                    Email de contact</option>
                                <option value="TEXT" {{ 'TEXT' == $content->type ? 'selected' : null }}>
                                    Texte</option>
                            </select>
                        </div>
                    </div>
                    <div id='title-container' class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="title">Titre du contenu</label>
                            <input type="text" class="form-control" name="title" id="title" aria-describedby="helpTitle" value='{{ $content->title }}'>
                        </div>
                    </div>
                    <div id="url-container" class="col-12 offset-md-6 col-md-6">
                        <label for="url">URL</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="https-prepend">https://</span>
                            </div>
                            <input class="form-control" type="text" name="url" aria-describedby="helpUrl" value="{{ preg_replace('/http[s]?:\/\//', '', $content->url) }}">
                        </div>
                        <small id="helpUrl" class="form-text text-muted">Cela peut être une URL externe ou interne au site.</small>
                    </div>
                </div>

                <div id='sections-container'>
                    @php $index = 0; @endphp
                    @foreach ($content->sections as $section)
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="title">Titre</label>
                            <input type="text" class="form-control" name="section[{{ $index }}][title]" id="title" aria-describedby="helpTitle" value='{{ $section->title }}'>
                            <small id="helpTitle" class="form-text text-muted">Le titre de la section</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="text">Texte</label>
                            <textarea class="form-control tiny-mce" name="section[{{ $index }}][text]" id="text" aria-describedby="helpText" rows='15'>{{ $section->text }}</textarea>
                            <small id="helpText" class="form-text text-muted">Le texte de la section</small>
                        </div>
                    </div>
                    @php $index++; @endphp
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- Tiny MCE --}}
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '.tiny-mce',
                plugins: "image"
            });

            updateForm();
        });
    </script>

    <script>
        $('#type').change(function() {
            updateForm();
        });

        function updateForm()
        {
            type = $('#type').val();

            console.log(type);

            if ('CONTENT' !== type) {
                $('#sections-container').hide();
            } else {
                $('#sections-container').show();
            }

            if ('LINK' !== type) {
                $('#url-container').hide();
            } else {
                $('#url-container').show();
            }

            if ('TEL' === type) {
                $('#title-container label').text('Numéro de téléphone');
            } else if ('EMAIL' === type) {
                $('#title-container label').text('Email');
            } else if ('CONTENT' === type) {
                $('#title-container label').text('Titre du contenu');
            } else if ('LINK' === type) {
                $('#title-container label').text('Nom du lien');
            } else if ('TEXT' === type) {
                $('#title-container label').text('Texte');
            }
        }
    </script>
@endsection
