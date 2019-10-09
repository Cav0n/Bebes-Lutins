@extends('templates.customer-area')

@section('body')
<div class="row">
    <div class="col-8 col-xl-9">
        <p class='h5 font-weight-bold'>Mes informations personnelles</p>
        <p class='mb-0'>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p class='mb-0'>Inscrit depuis le {{ Auth::user()->created_at->formatLocalized('%e %B %Y') }}</p>
        <p class='mb-0'>Date de naissance : @if(Auth::user()->birthdate != null){{  Auth::user()->birthdate->formatLocalized('%e %B %Y') }} @else non indiquée @endif</p> 
        <p class='mb-0'>Téléphone : {{ trim( chunk_split(Auth::user()->phone, 2, ' ')) }} </p>
    </div>
    <div class="col-4 col-xl-3">
        <button id='desktop-button' type="button" class="btn btn-outline-dark w-100 d-none d-md-flex rounded-0">
            <p class='text-center mb-0 mx-auto'>Modifier</p></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-8 col-xl-9">
        <p class='h5 font-weight-bold'>Mot de passe</p>
        <p class='mb-0'>Vous pouvez modifier votre mot de passe à tout moment.</p>
    </div>
    <div class="col-4 col-xl-3">
        <button id='desktop-button' type="button" class="btn btn-outline-dark w-100 d-none d-md-flex rounded-0">
            <p class='text-center mb-0 mx-auto'>Modifier</p></button>
    </div>
</div>
<div class="row mt-4 pt-4 border-top">
    <div class="col-8 col-xl-9">
        <p class='h5 font-weight-bold'>Newsletter</p>
        @if(Auth::user()->wantNewsletter) <p class='mb-0'> Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
        @else <p class='mb-0'> Vous avez indiqué ne pas vouloir recevoir les actualités Bébés Lutins.</p>
        @endif
    </div>
    <div class="col-4 col-xl-3">
        @if(Auth::user()->wantNewsletter) 
        <button id='desktop-button' type="button" class="btn btn-outline-success border-success w-100 d-none d-md-flex rounded-0 ld-ext-right" onclick='invert_newsletter($(this))'>
            <p class='text-center mb-0 mx-auto d-flex flex-column justify-content-center'>Activé</p><div class="ld ld-ring ld-spin"></div></button>
        @else 
        <button id='desktop-button' type="button" class="btn btn-outline-danger w-100 d-none d-md-flex rounded-0 ld-ext-right" onclick='invert_newsletter($(this))'>
            <p class='text-center mb-0 mx-auto d-flex flex-column justify-content-center'>Désactivé</p><div class="ld ld-ring ld-spin"></div></button>
        @endif
    </div>
</div>

<script>
    function invert_newsletter(btn){
        $.ajax({
            url: "/espace-client/newsletter-invert",
            type: 'POST',
            data: { },
            success: function(data){
                console.log('Toggle newsletter.');
                location.reload();
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        })
        .done(function( data ) {
            
        }); 
    }
</script>
    
@endsection