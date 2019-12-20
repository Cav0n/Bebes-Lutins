@extends('templates.template')

@section('head-options')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/shopping-cart/index.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">
    {{--  JQUERY FORMS  --}}
    <script src="{{asset('js/jquery/jquery.form.min.js')}}"></script>
@endsection

@section('content')
<main>
    <div class="row justify-content-center pt-0 pt-md-5 pb-5 dim-background m-0">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">

            {{--  Thanks  --}}
            <div class="col-12 p-3 bg-white border">
                <h1 class='d-flex h2'>
                    <div class='svg-container mr-2 mt-1 d-none d-md-block noselect' style="max-height:2rem;max-width:2rem;">
                        <img src="{{asset('images/icons/forbidden.svg')}}" alt="" class='svg h-100 w-100' style=''>
                    </div>
                    Une erreur est survenue
                </h1>
                <p class='mb-0'>
                    Il semblerait que le paiement de votre commande ait échoué, ou que vous ayez annulé
                    le paiement. Vous ne serez donc pas débité.<br>
                    <br>
                    Si vous pensez qu'il s'agit d'un problème de notre côté vous pouvez nous contacter
                    à l'adresse <a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a><br>
                    <br>
                    Vous pouvez retenter de passer commande en cliquant sur le bouton ci-dessous : 
                </p>
                <div class="col-12 p-0 d-flex justify-content-center">
                    <button class='btn btn-primary rounded-0' onclick='load_url("/panier")'>Retourner au panier</button>                    
                </div>
            </div>
        </div>
    </div>
</main>

{{--  Hide answer precision  --}}
<script>
    $('#answer-precision-container').hide();
    $('#thank_for_answer').hide();

    $('#send_answer').attr("disabled", true);
    $('.answer').on('click', function(){
        $('#send_answer').attr("disabled", false);
        if(this.value == 'other'){
            $('#answer-precision-container').fadeIn(200);
        } else {
            $('#answer-precision-container').fadeOut(200);
        }
    });
</script>

{{--  AJAX Forms  --}}
<script>
    // wait for the DOM to be loaded
    $(function() {
        // bind 'myForm' and provide a simple callback function
        $('#know_thanks_to').ajaxForm(function() {
            $('#know_thanks_to_container').hide();
            $('#thank_for_answer').show();
            alert('Merci de votre retour !');
        });
     });
</script>
@endsection