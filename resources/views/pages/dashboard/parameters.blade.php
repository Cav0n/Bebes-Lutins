@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Paramètres
        </h1>
    </div>

    <div class="card-body">

        <div class="form-group d-flex flex-column">
            <label for="informationMessage">Message d'information</label>
            <button id='toggle_button' type="button" class="btn btn-danger max-content mb-3 rounded-0 ld-ext-right" onclick='desactivate_informationMessage()'>
                Désactiver
                <div class="ld ld-ring ld-spin"></div>
            </button>
            <div id='textarea-container'>
                <textarea class="form-control" name="informationMessage" id="informationMessage" aria-describedby="helpInformationMessage">{{\App\Parameter::where('name', 'informationMessage')->first()->value}}</textarea>
                <small id="helpInformationMessage" class="form-text text-muted">
                    Un message qui s'affiche en haut du site pour indiquer une information (ex: congés)</small>
            </div>
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

    $(document).ready(function(){
        if($('#informationMessage').val() == ''){
            $('#textarea-container').hide();
            $('#toggle_button').text('Activer')
                                .removeClass('btn-danger')
                                .addClass('btn-success')
                                .attr('onclick', 'activate_informationMessage()');
        }
    });

    function desactivate_informationMessage(){
        $('#informationMessage').val('');
        save_parameters($('#toggle_button'));
    }
    function activate_informationMessage(){
        $('#textarea-container').show();
        $('#toggle_button').text('Désactiver')
                            .removeClass('btn-success')
                            .addClass('btn-danger')
                            .attr('onclick', 'desactivate_informationMessage()');
    }

    function save_parameters(btn){
        informationMessage = $('#informationMessage').val();

        $.ajax({
            url: '/dashboard/parametres/sauvegarder',
            type: 'POST',
            data: { informationMessage: informationMessage },
            success: function(response){
                btn.removeClass('running');
                if(informationMessage == ''){
                    $('#textarea-container').hide();
                    $('#toggle_button').text('Activer')
                                        .removeClass('btn-danger')
                                        .addClass('btn-success')
                                        .attr('onclick', 'activate_informationMessage()');
                }
            },
            beforeSend: function(){
                btn.addClass('running');
            }
        });

    }
</script>

@endsection