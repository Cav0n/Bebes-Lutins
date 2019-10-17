@extends('templates.dashboard')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/tagify/tagify.css')}}">
    <script src="{{asset('js/tagify/jQuery.tagify.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/dropzone/dropzone.css')}}">
    <script src="{{asset('js/dropzone/dropzone.js')}}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/produits/categories' class='text-muted'>< Toutes les catégories</a>        
    </div>
</div>

{{-- Errors --}}
@if ($errors->any())
<div class="col-lg-12 p-0 mt-2">
    <div class="alert alert-danger">
        <ul class='mb-0'>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Success --}}
@if(session()->has('success-message'))
<div class="col-lg-12 p-0 mt-2">
    <div class="alert alert-success px-3 mb-0">
        <p class='text-success font-weight-bold mb-0'>{{session('success-message')}}</p>
    </div>
</div>
@endif

<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            {{$category->name}}
        </h1>
    </div>
    <div class="card-body">
        <form action='/dashboard/produits/categories/edition/{{$category->id}}' method="POST">
            @csrf

            <input type="hidden" name="main_image_name" id="mainImageName" value='{{old('main_image_name', $category->mainImage)}}' required>

            <div class="row m-0 mb-2">
                <div class="col-4 p-0">
                    <div id='mainImage' class="dropzone mb-2 @error('name') border-danger text-danger @enderror border rounded row m-0 justify-content-center h-100"></div> 
                    @error('main_image_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-8">
                    <div class="form-group m-0">
                        <label for="name">Nom de la catégorie</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" aria-describedby="helpName" placeholder="" value='{{old("name", $category->name)}}' required>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-0">
                        <label for="parent_id">Catégorie parente</label>
                        <select class="custom-select" name="parent_id" id="parent_id">
                            <option value='null' selected>Aucune</option>
                            @foreach ($categories as $o_category)
                                <option value="{{$o_category->id}}">{{$o_category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-0">
                        <label for="rank">Rang</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                            </div>
                            <input type="number" class="form-control @error('rank') is-invalid @enderror" name="rank" id="rank" aria-describedby="helpRank" placeholder="" min="0" step="1" value='{{old('rank', $category->rank)}}' required>
                            @error('rank')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="5">{{old('description', $category->description)}}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mb-0">
                <label for="tags">Tags</label>
                <input id='tags' class="form-control @error('tags') is-invalid @enderror" name='tags' value='@foreach($category->tags as $tag) {{$tag->name}}, @endforeach'>
                @error('tags')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror 
                <button class='btn btn-outline-dark rounded-0 mt-2 tags--removeAllBtn' type='button'>Supprimer tous les tags</button>
            </div>

            <div class="custom-control custom-checkbox pointer my-2">
                <input id='is-hidden' name='is-hidden' type="checkbox" class="custom-control-input pointer is-hidden-checkbox" @if(old('is-hidden', $category->isHidden)) checked @endif>
                <label class="custom-control-label noselect pointer" for="is-hidden">Categorie cachée</label>
            </div>

            <button type="submit" class="btn btn-outline-secondary">Enregistrer</button>

        </form>
    </div>
</div>

@if(count($category->childs))
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Catégories enfants
        </h1>
    </div>
    <div class="card-body">
        @foreach ($category->childs as $child)
            <p>{{$child->name}}</p>
        @endforeach
    </div>
</div>
@endif

{{-- Ajax setup --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

{{-- TAGIFY --}}
<script>
    $input = $('#tags').tagify();

    // get the Tagify instance assigned for this jQuery input object so its methods could be accessed
    var tags = $input.data('tagify');
    
    // bind the "click" event on the "remove all tags" button
    $('.tags--removeAllBtn').on('click', tags.removeAllTags.bind(tags));
</script>

{{-- DROPZONE --}}
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    // Disable auto discover for all elements:
    Dropzone.autoDiscover = false;

    // MAINIMAGE
    mainImageDropzone = $("#mainImage").dropzone({
        url: "/upload_image",
        maxFiles: 1,
        addRemoveLinks: true,
        dictDefaultMessage: "Cliquez pour ajouter l'image de la catégorie",
        dictFileTooBig: "L'image est trop lourde (maximum 5 Mo)",
        dictResponseError: "Une erreur est survenue (Code d'erreur : @{{statusCode}})",
        dictCancelUpload: "Annuler l'upload",
        dictUploadCanceled: "Upload annulé",
        dictCancelUploadConfirmation: "Êtes-vous sûr de vouloir annuler l'upload ?",
        dictRemoveFile: "Supprimer l'image",
        dictRemoveFileConfirmation: "Êtes-vous sûr de vouloir supprimer l'image ?",
        dictMaxFilesExceeded: "Vous ne pouvez ajouter qu'une image",
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        },
        init: function() {
            this.on("success", function(file, response) { 
                filename = response.filename;

                console.log(filename);
                $('#mainImageName').val(filename);
                file.name = filename;
            });
            this.on("removedfile", function(file) {
                $.ajax({
                    url: "/delete_image",
                    type: 'DELETE',
                    data: { image:file.name },
                    success: function(data){
                        console.log('['+file.name+'] Image bien supprimé');
                        $('#mainImageName').val("");
                    }
                });
            });
            //POPULATE
            // Create the mock file:
            var mockFile = { name: "{{$category->mainImage}}", size: {{$category->images->first()->size}} };

            // Call the default addedfile event handler
            this.emit("addedfile", mockFile);

            // And optionally show the thumbnail of the file:
            this.emit("thumbnail", mockFile, "{{'/images/categories/' . $category->mainImage}}");

            // Make sure that there is no progress bar, etc...
            this.emit("complete", mockFile);
        }
    });
</script>

@endsection