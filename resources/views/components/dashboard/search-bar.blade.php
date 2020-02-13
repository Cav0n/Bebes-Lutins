<div class="row">
    <div class="col">
        <div class="form-group">
            <div class="input-group mb-3">
                <input type="search" name="search" id="search-bar" class="form-control" aria-describedby="helpSearch">

                <div class="input-group-append">
                    <button id='search-button' class="btn btn-secondary d-flex flex-column justify-content-center ld-over" type="button" onclick='search()'>
                        <p class='d-none d-sm-flex mb-0'>Rechercher</p>
                        <img class='d-flex d-sm-none svg' style="fill:grey" src='{{asset('images/icons/search.svg')}}'>
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                    <button id='cancel-search-button' class='btn btn-danger flex-column justify-content-center ld-over' type="button">
                        <p class='d-none d-sm-flex mb-0'>Retour</p>
                        <img class='d-flex d-sm-none svg' style="fill:grey" src='{{asset('images/icons/close.svg')}}'>
                        <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#cancel-search-button').hide();

    $("#search-bar").keyup(function(event) {
        if($(this).val() == ''){
            $('#cancel-search-button').removeClass('d-flex');
        } else {
            $('#cancel-search-button').addClass('d-flex');
        }

        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });

    $("#cancel-search-button").on('click', function(){
        $('#search-bar').val('');
        $("#search-button").click();
        $('#cancel-search-button').removeClass('d-flex');
    });
</script>