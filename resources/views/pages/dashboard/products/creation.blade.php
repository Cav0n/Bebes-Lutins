@extends('templates.dashboard')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/tagify/tagify.css')}}">
    <script src="{{asset('js/tagify/jQuery.tagify.min.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/dropzone/dropzone.css')}}">
    <script src="{{asset('js/dropzone/dropzone.js')}}"></script>

    <style>
        .ck-editor__editable_inline {
            min-height: 10rem;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 pt-3">
        <a href='/dashboard/produits' class='text-muted'>< Tous les produits</a>        
    </div>
</div>
<div class='row'>
    <div class='col-12 pt-3'>
        <a href='#' class='text-muted' onclick='open_product_importation()'>Importer les informations à partir d'un autre produit</a>
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

            <input type="hidden" name="main_image_name" id="mainImageName" required>
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
                <div class="col-md-4 p-0 pb-3 pb-md-0">
                    <div id='mainImage' class="dropzone mb-2 @error('name') border-danger text-danger @enderror border rounded row m-0 justify-content-center h-100"></div> 
                    @error('main_image_name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-8 p-0 pl-md-3">
                    <div class="form-group m-0">
                        <label for="reference">Référence</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                            </div>
                            <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" id="reference" aria-describedby="helpReference" placeholder="" value='{{old('reference')}}'>
                            @error('reference')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label for="name">Nom du produit</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" aria-describedby="helpName" placeholder="" value='{{old("name")}}' required>
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-0">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" aria-describedby="helpStock" placeholder="" min='0' step='1' value='{{old('stock')}}' required>
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
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" aria-describedby="helpPrice" placeholder="" min="0.01" step="0.01" value='{{old('price')}}' required>
                            @error('price')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="categories">Catégories</label>
                <input id='categories' class="form-control @error('categories') is-invalid @enderror" name='categories' value='' placeholder="Tapez le nom d'une catégorie">
                @error('categories')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror 
                <button id='toggle-categories-list-button' class='btn btn-outline-dark mt-2 isHidden' type='button' >Afficher les catégories</button>
            </div>
            
            <div class="form-group">
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{old('description')}}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>

            <div id='thumbnails' class='dropzone my-2 border rounded text-muted d-flex'></div>

            <div class="form-group mb-0">
                <label for="tags">Tags</label>
                <input id='tags' class="form-control @error('tags') is-invalid @enderror" name='tags' value=''>
                @error('tags')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror 
            </div>

            <div class="form-group">
                <label for="helpMessage">Message spécial</label>
                <textarea class="form-control" name="helpMessage" id="helpMessage" aria-describedby="helpMessageHelp" placeholder="">{{old('helpMessage')}}</textarea>
                <small id="helpMessageHelp" class="form-text text-muted">Par exemple : "Laissez nous vos choix de coloris dans le champ commentaires dans votre panier"</small>
            </div>

            <div class="custom-control custom-checkbox pointer my-2">
                <input id='is-hidden' name='is-hidden' type="checkbox" class="custom-control-input pointer is-hidden-checkbox">
                <label class="custom-control-label noselect pointer" for="is-hidden">Produit caché</label>
            </div>

            <div id="characteristics-container" class="my-2">
                <button type="button" class="btn btn-outline-dark rounded-0" onclick="add_characteristic($(this).parent())">Ajouter une caractéristique</button>
            </div>

            <button id='save-btn' type="submit" class="btn btn-outline-secondary ld-ext-right">
                Enregistrer
                <div class="ld ld-hourglass ld-squeeze"></div>
            </button>

        </form>
    </div>
</div>

@include('components.dashboard.import-product')

{{--  prepare page  --}}
<script>
    $(document).ready(function(){
        $(".customSuggestionsList").hide();
        $('#toggle-categories-list-button').on('click', function(){
            $(".customSuggestionsList").fadeToggle();
            if($(this).hasClass('isHidden')){
                $(this).text("Cacher les catégories");
                $(this).removeClass('isHidden');
            } else {
                $(this).text("Afficher les catégories");
                $(this).addClass('isHidden');
            }
            
        });
        $("#save-btn").on('click', function(){
            $(this).addClass('running');
        });
    });
</script>

{{-- CHARACTERISTICS --}}
<script>
    characteristics_index = 0;

    function add_characteristic(characteristics_container){
        html = `
        <div class="characteristic p-3 border my-2">
            <div class="form-group col-6 p-0">
                <label for="characteristic_name">Nom de la caractéristique</label>
                <input type="text" class="form-control characteristic_name" name="characteristics[`+ characteristics_index +`][name]" aria-describedby="helpCharacteristicName" placeholder="Taille" required>
                <small id="helpCharacteristicName" class="form-text text-muted">Par exemple "taille", "couleur"...</small>
            </div>

            <div class="form-group">
                <label for="message">Message d'aide</label>
                <textarea class="form-control" name="characteristics[`+ characteristics_index +`][message]" id="message" aria-describedby="helpMessage" ></textarea>
                <small id="helpMessage" class="form-text text-muted">Par exemple : "Laissez nous vos choix de coloris dans le champ commentaires dans votre panier"</small>
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
    $input_tags = $('#tags').tagify();
    $input_categories = $('#categories').tagify({
        enforceWhitelist : true,
        whitelist : [@foreach(App\Category::where('isDeleted', 0)->orderBy('name')->get() as $category) "{{$category->name}}", @endforeach],
        dropdown: {
            position: "manual",
            maxItems: Infinity,
            enabled: 0,
            classname: "customSuggestionsList"
        },
    });

    // get the Tagify instance assigned for this jQuery input object so its methods could be accessed
    var jqTagify = $input_tags.data('tagify');
    var categories = $input_categories.data('tagify');
    
    // bind the "click" event on the "remove all tags" button
    $('.tags--removeAllBtn').on('click', jqTagify.removeAllTags.bind(jqTagify))
    $('.categories--removeAllBtn').on('click', categories.removeAllTags.bind(categories));

    categories.on("dropdown:show", onSuggestionsListUpdate)
          .on("dropdown:hide", onSuggestionsListHide)

    renderSuggestionsList()

    // ES2015 argument destructuring
    function onSuggestionsListUpdate({ detail:suggestionsElm }){
        console.log(  suggestionsElm  )
    }

    function onSuggestionsListHide(){
        console.log("hide dropdown")
    }

    // https://developer.mozilla.org/en-US/docs/Web/API/Element/insertAdjacentElement
    function renderSuggestionsList(){
        categories.dropdown.show.call(categories) // load the list
        categories.DOM.scope.parentNode.appendChild(categories.DOM.dropdown)
    }
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
                $('#mainImageName').val(filename);
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

{{--  CLASSIC EDITOR  --}}
<script src="{{asset('js/ckfinder/ckfinder.js')}}"></script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script>
	ClassicEditor.create( document.querySelector( '#description' ) )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>


<script>
    function open_product_importation(){
        $('#product-selection-popup').modal('show');
    }

    function import_product(id){
        $.ajax({
            url: "/produits2/" + id,
            type: 'POST',
            data: { },
            success: function(response){
                console.log(response);
                complete_fields(response);
                $('#product-selection-popup').modal('hide');
            },
            error: function(response) {
                console.log(response.responseJSON);
            }
        });
    }

    function complete_fields(product){
        $('#reference').val(product.reference);
        $('#name').val(product.name);
        $('#stock').val(product.stock);
        $('#price').val(product.price);
        $('#description').text(product.description);
        editor.setData(product.description);

        product.categories.forEach(function(element){
            $('#categories').data('tagify').addTags(element.name);
        });

        product.tags.forEach(function(element){
            $('#tags').data('tagify').addTags(element.name);
        });
    }
</script>

@endsection