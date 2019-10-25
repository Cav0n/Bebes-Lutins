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

            {{--  Image  --}}
            <div class="image-container d-flex justify-content-center my-3">
                <img src='{{asset("images/utils/thanks.png")}}' style='max-height:15rem;'>
            </div>

            {{--  Thanks  --}}
            <div class="col-12 p-3 bg-white border">
                <h1 class='d-flex h2'>
                    <div class='svg-container mr-2 mt-1 d-none d-md-block noselect' style="max-height:2rem;max-width:2rem;">
                        <img src="{{asset('images/icons/success.svg')}}" alt="" class='svg h-100 w-100' style=''>
                    </div>
                    Merci de votre commande. 
                </h1>
                <p class='mb-0'>
                    Bébés Lutins et son équipe vous remercient de votre commande.
                    Départ de notre atelier dès que le colis est prêt.
                </p>
                <BR>
                <p class='mb-0'>Vous allez recevoir une confirmation de commande par mail.</p>
                <p>Retrouvez le suivi de votre commande dans votre espace "mon compte", rubrique "mes commandes". </p>
                <div class="col-12 p-0 d-flex justify-content-center">
                    <button class='btn btn-primary rounded-0'>Voir mes commandes</button>                    
                </div>
            </div>

            @if(! DB::table('knowed_thanks_to')->where('user_id', Auth::user()->id)->exists())
            {{--  Known thanks to  --}}
            <div id='know_thanks_to_container' class="col-12 p-3 bg-white border mt-3">
                <h1 class="h2">Vous avez quelques secondes ?</h1>
                <p>
                    Pour nous aider à progresser, dites nous comment vous nous avez connus :
                </p>
                <form id='know_thanks_to' class='noselect' action="/know_thanks_to/add" method="post">
                    @csrf
                    <input type="hidden" name='user_id' value="{{Auth::user()->id}}">

                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='word_of_mouth'>
                        <span class="custom-control-label">Bouche à oreille</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='google'>
                        <span class="custom-control-label">Google</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='social_media'>
                        <span class="custom-control-label">Réseaux sociaux</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='health_professional'>
                        <span class="custom-control-label">Professionel de la santé</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='fair_and_show'>
                        <span class="custom-control-label">Foire et salon</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='media'>
                        <span class="custom-control-label">Médias (télévison, radio...)</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input type="radio" name="answer" id="answer" class="custom-control-input answer" value='other'>
                        <span class="custom-control-label">Autre</span>
                    </label>
                    <div class="form-group" id='answer-precision-container'>
                        <input type="text" class="form-control" name="answer_precision" id="answer_precision" aria-describedby="helpAnswerPrecision" placeholder="">
                        <small id="helpId" class="form-text text-muted">De quel manière vous nous avez connus ? (Facultatif)</small>
                    </div>
                    <button id='send_answer' type="submit" class="btn btn-primary rounded-0">Envoyer</button>
                </form>
            </div>

            {{--  Known thanks to  --}}
            <div id='thank_for_answer' class="col-12 p-3 bg-white border mt-3">
                <h1 class="h2 mb-0">Merci de votre retour !</h1>
            </div>
            @endif
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