<div id='loader-container' class='d-none' style="position: fixed;top: 0;left: 0;background: rgba(100,100,100,0.7);z-index: 2000;height: 100vh;width: 100vw;">
    <img class='mx-auto my-auto' src="{{asset('images/icons/heart-animated.svg')}}">
</div>

<script>
function init_loading(){
    $('#loader-container').removeClass('d-none').addClass('d-flex');
}

function stop_loading(){
    $('#loader-container').removeClass('d-flex').addClass('d-none');
}
</script>