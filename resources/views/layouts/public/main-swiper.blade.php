<div id='swiper-container' class="row d-none d-md-flex">
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide"><img style='height:100%;width:100%;' src='{{asset('images/swiper/main/1.jpg')}}'></div>
            <div class="swiper-slide"><img style='height:100%;width:100%;' src='{{asset('images/swiper/main/2.jpg')}}'></div>
            <div class="swiper-slide"><img style='height:100%;width:100%;' src='{{asset('images/swiper/main/3.jpg')}}'></div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>

<script>
    var mySwiper = new Swiper ('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
    
        // If we need pagination
        pagination: {
        el: '.swiper-pagination',
        },
    
        // Navigation arrows
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        },
    
        // And if we need scrollbar
        scrollbar: {
        el: '.swiper-scrollbar',
        },
    })
</script>