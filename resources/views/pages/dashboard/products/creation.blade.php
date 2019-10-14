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
        <a href='/dashboard/produits' class='text-muted'>< Tous les produits</a>        
    </div>
</div>
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Nouveau produit
        </h1>
    </div>
    <div class="card-body">
        <form action='/dashboard/produits/nouveau' method="POST">
            @csrf

            <input type="hidden" name="main_image_name" id="mainImageName">
            <div id='thumbnails-names'>
                <input type="hidden" name="thumbnails_names[]" class="thumbnails_names">
            </div>

            {{-- Errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class='mb-0'>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            {{-- Success --}}
            @if(session()->has('success-message'))
            <div class="col-lg-12">
                <div class="alert alert-success px-3 mb-0">
                    <p class='text-success font-weight-bold mb-0'>{{session('success-message')}}</p>
                </div>
            </div>
            @endif

            <div class="row m-0 mb-2">
                <div class="col-4 p-0">
                    <div id='mainImage' class="dropzone mb-2 border rounded text-muted row m-0 justify-content-center h-100"></div> 
                </div>
                <div class="col-8">
                    <div class="form-group m-0">
                        <label for="name">Nom du produit</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" aria-describedby="helpName" placeholder="" required value='{{old("name")}}'>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-0">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" aria-describedby="helpStock" placeholder="" min='0' step='1' value='{{old('stock')}}'>
                    </div>
                    <div class="form-group m-0">
                        <label for="price">Prix</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">€</div>
                            </div>
                            <input type="number" class="form-control" name="price" id="price" aria-describedby="helpPrice" placeholder="" min="0.01" step="0.01">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{old('description')}}</textarea>
            </div>

            <div id='thumbnails' class='dropzone my-2 border rounded text-muted'></div>

            <div class="form-group mb-0">
                <label for="tags">Tags</label>
                <input id='tags' class="form-control" name='tags' value=''> 
                <button class='btn btn-outline-dark rounded-0 mt-2 tags--removeAllBtn' type='button'>Supprimer tous les tags</button>
            </div>

            <div class="custom-control custom-checkbox pointer my-2">
                <input id='is-hidden' name='is-hidden' type="checkbox" class="custom-control-input pointer is-hidden-checkbox">
                <label class="custom-control-label noselect pointer" for="is-hidden">Caché</label>
            </div>

            <button type="submit" class="btn btn-outline-secondary">Enregistrer</button>

        </form>
    </div>
</div>

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
    var jqTagify = $input.data('tagify');
    
    // bind the "click" event on the "remove all tags" button
    $('.tags--removeAllBtn').on('click', jqTagify.removeAllTags.bind(jqTagify))
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
        dictDefaultMessage: "Cliquez pour ajouter une image principale",
        dictFileTooBig: "L'image est trop lourde (maximum 5 Mo)",
        dictResponseError: "Une erreur est survenue (Code d'erreur : @{{statusCode}})",
        dictCancelUpload: "Annuler l'upload",
        dictUploadCanceled: "Upload annulé",
        dictCancelUploadConfirmation: "Êtes-vous sûr de vouloir annuler l'upload ?",
        dictRemoveFile: "Supprimer l'image",
        dictRemoveFileConfirmation: "Êtes-vous sûr de vouloir supprimer l'image ?",
        dictMaxFilesExceeded: "Vous ne pouvez ajouter qu'une image principale",
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
        }
    });

    // THUMBNAILS
    thumbnailsDropzone = $("#thumbnails").dropzone({
        url: "/upload_image",
        maxFiles: 4,
        addRemoveLinks: true,
        dictDefaultMessage: "Cliquez pour ajouter une vignette (4 maximum)",
        dictFileTooBig: "La vignette est trop lourde (maximum 5 Mo)",
        dictResponseError: "Une erreur est survenue (Code d'erreur : @{{statusCode}})",
        dictCancelUpload: "Annuler l'upload",
        dictUploadCanceled: "Upload annulé",
        dictCancelUploadConfirmation: "Êtes-vous sûr de vouloir annuler l'upload ?",
        dictRemoveFile: "Supprimer l'image",
        dictRemoveFileConfirmation: "Êtes-vous sûr de vouloir supprimer l'image ?",
        dictMaxFilesExceeded: "Vous ne pouvez ajouter que @{{maxFiles}} vignettes",
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        },
        init: function() {
            this.on("success", function(file, response) { 
                console.log(response.filename);
                $('#thumbnails-names').append("<input type='hidden' name='thumbnails_names[]' class='thumbnails_names' value="+ response.filename +">");
            });
            this.on("removedfile", function(file) {
                $.ajax({
                    url: "/delete_image",
                    type: 'DELETE',
                    data: { image:file.name },
                    success: function(data){
                        console.log('['+file.name+'] Image bien supprimé');
                        $("input[value='"+file.name+"']").remove();
                    }
                });
            });
        }
    });
</script>

@endsection