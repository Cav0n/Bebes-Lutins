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
            {{$product->name}}
        </h1>
    </div>
    <div class="card-body">
        <form action='/dashboard/produits/edition/{{$product->id}}' method="POST">
            @csrf

            <input type="hidden" name="main_image_name" id="mainImageName" value='{{$product->mainImage}}' required>
            <div id='thumbnails-names'>
                @if($product->thumbnails != null)
                @foreach ($product->thumbnails as $thumbnail)
                <input type="hidden" name="thumbnails_names[]" class="thumbnails_names" value='{{$thumbnail->name}}'>
                @endforeach
                @endif
            </div>

            <div class="row m-0 mb-2">
                <div class="col-4 p-0">
                    <div id='mainImage' class="dropzone mb-2 @error('name') border-danger text-danger @enderror border row m-0 justify-content-center h-100"></div> 
                    @error('main_image_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-8">
                    <div class="form-group m-0">
                        <label for="name">Nom du produit</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" aria-describedby="helpName" placeholder="" value='{{old("name", $product->name)}}' required>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-0">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" aria-describedby="helpStock" placeholder="" min='0' step='1' value='{{old('stock', $product->stock)}}' required>
                        @error('stock')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-0">
                        <label for="price">Prix</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">€</div>
                            </div>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" aria-describedby="helpPrice" placeholder="" min="0.01" step="0.01" value='{{old('price', $product->price)}}' required>
                            @error('price')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="5">{{old('description', $product->description)}}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div id='thumbnails' class='dropzone my-2 border text-muted d-flex'></div>

            <div class="form-group mb-0">
                <label for="tags">Tags</label>
                <input id='tags' class="form-control @error('tags') is-invalid @enderror" name='tags' value='@foreach($product->tags as $tag) {{$tag->name}}, @endforeach'>
                @error('tags')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror 
                <button class='btn btn-outline-dark rounded-0 mt-2 tags--removeAllBtn' type='button'>Supprimer tous les tags</button>
            </div>

            <div class="custom-control custom-checkbox pointer my-2">
                <input id='is-hidden' name='is-hidden' type="checkbox" class="custom-control-input pointer is-hidden-checkbox" value='{{old("is-hidden", $product->isHidden)}}'>
                <label class="custom-control-label noselect pointer" for="is-hidden">Caché</label>
            </div>

            <div id="characteristics-container" class="my-2">
                <button type="button" class="btn btn-outline-dark rounded-0" onclick="add_characteristic($(this).parent())">Ajouter une caractéristique</button>
                <?php $index = 0;?>
                @if($product->characteristics != null)
                @foreach ($product->characteristics as $characteristic)
                <div class="characteristic p-3 border my-2">
                    <div class="form-group col-6 p-0">
                        <label for="characteristic_name">Nom de la caractéristique</label>
                        <input type="text" class="form-control characteristic_name" name="characteristics[{{$index}}][name]" aria-describedby="helpCharacteristicName" placeholder="Taille" value='{{$characteristic->name}}' required>
                        <small id="helpCharacteristicName" class="form-text text-muted">Par exemple "taille", "couleur"...</small>
                    </div>
                    <div class="characteristic-options row m-0 d-flex flex-column">
                        <label>Options</label>
        
                        @if($characteristic->options != null)
                        @foreach ($characteristic->options as $option)
                        <div class='option d-flex my-2'>
                            <input type="text" class="form-control characteristic_options mr-2" name="characteristics[{{$index}}][options][]" aria-describedby="helpCharacteristicOptions" placeholder="" value="{{$option->name}}" required>
                            <button class="btn btn-outline-danger" onclick="remove_option($(this))">Supprimer</button>
                        </div>
                        @endforeach
                        @endif
        
                        <div class='buttons d-flex my-2'>
                            <button type='button' class="btn btn-dark rounded-0 max-content" onclick="add_option($(this), {{$index}})">Ajouter une option</button>
                            <button type='button' class="btn btn-danger rounded-0 max-content mx-3" onclick="$(this).parent().parent().parent().remove()">Supprimer la caractéristique</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-outline-secondary">Enregistrer</button>

        </form>
    </div>
</div>

{{-- CHARACTERISTICS --}}
<script>
    characteristics_index = {{$index}};

    function add_characteristic(characteristics_container){
        html = `
        <div class="characteristic p-3 border my-2">
            <div class="form-group col-6 p-0">
                <label for="characteristic_name">Nom de la caractéristique</label>
                <input type="text" class="form-control characteristic_name" name="characteristics[`+ characteristics_index +`][name]" aria-describedby="helpCharacteristicName" placeholder="Taille" required>
                <small id="helpCharacteristicName" class="form-text text-muted">Par exemple "taille", "couleur"...</small>
            </div>
            <div class="characteristic-options row m-0 d-flex flex-column">
                <label>Options</label>

                <div class='option d-flex my-2'>
                    <input type="text" class="form-control characteristic_options mr-2" name="characteristics[`+ characteristics_index +`][options][]" aria-describedby="helpCharacteristicOptions" placeholder="" required>
                </div>

                <div class='buttons d-flex my-2'>
                    <button type='button' class="btn btn-dark rounded-0 max-content" onclick="add_option($(this), `+ characteristics_index +`)">Ajouter une option</button>
                    <button type='button' class="btn btn-danger rounded-0 max-content mx-3" onclick="$(this).parent().parent().parent().remove()">Supprimer la caractéristique</button>
                </div>
            </div>
        </div>`;
        characteristics_container.append(html);
        characteristics_index++;
    }

    function add_option(btn, index){
        html = `
        <div class="option d-flex my-2">
            <input type="text" class="form-control characteristic_options  mr-2" name="characteristics[`+ index +`][options][]" aria-describedby="helpCharacteristicOptions" placeholder="" required>
            <button class="btn btn-outline-danger" onclick="remove_option($(this))">Supprimer</button>
        </div>`;
        btn.parent().before(html);
    }

    function remove_option(btn){
        btn.parent().remove();
    }
</script>

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
            //POPULATE
            // Create the mock file:
            var mockFile = { name: "{{$product->mainImage}}", size: {{$product->images->first()->size}} };

            // Call the default addedfile event handler
            this.emit("addedfile", mockFile);

            // And optionally show the thumbnail of the file:
            this.emit("thumbnail", mockFile, "{{'/images/products/' . $product->mainImage}}");

            // Make sure that there is no progress bar, etc...
            this.emit("complete", mockFile);
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
            //POPULATE
            @if($product->images != null)
            @foreach($product->images as $thumbnail)
            @if($thumbnail->name != $product->mainImage)
            // Create the mock file:
            var mockFile = { name: "{{$thumbnail->name}}", size: {{$thumbnail->size}}, }

            // Call the default addedfile event handler
            this.emit("addedfile", mockFile);

            // And optionally show the thumbnail of the file:
            this.emit("thumbnail", mockFile, "{{'/images/products/thumbnails/' . $thumbnail->name}}");

            // Make sure that there is no progress bar, etc...
            this.emit("complete", mockFile);
            @endif
            @endforeach
            @endif
        }
    });
    
</script>

@endsection