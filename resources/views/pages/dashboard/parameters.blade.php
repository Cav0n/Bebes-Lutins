@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Paramètres
        </h1>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label for="informationMessage">Message d'information</label>
            
            <textarea class="form-control" name="informationMessage" id="informationMessage" aria-describedby="helpInformationMessage">{{\App\Parameter::where('name', 'informationMessage')->first()->value}}</textarea>
            <small id="helpInformationMessage" class="form-text text-muted">
                Un message qui s'affiche en haut du site pour indiquer une information (ex: congés)</small>
        </div>
        <button type="button" class="btn btn-secondary ld-ext-right" onclick='save_parameters($(this))'>
            Sauvegarder
            <div class="ld ld-ring ld-spin"></div>
        </button>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function save_parameters(btn){
        informationMessage = $('#informationMessage').val();

        $.ajax({
            url: '/dashboard/parametres/sauvegarder',
            type: 'POST',
            data: { informationMessage: informationMessage },
            success: function(response){
                btn.removeClass('running');
            },
            beforeSend: function(){
                btn.addClass('running');
            }
        });

    }
</script>

@endsection