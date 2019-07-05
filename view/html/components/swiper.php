<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 19/11/2018
 * Time: 11:43
 */

?>

<!-- Slider main container -->
<div class="swiper-container desktop">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide"><img src="https://www.bebes-lutins.fr/view/assets/images/swiper/1.jpg"></div>
        <div class="swiper-slide"><img src="https://www.bebes-lutins.fr/view/assets/images/swiper/2.jpg"></div>
        <div class="swiper-slide"><img src="https://www.bebes-lutins.fr/view/assets/images/swiper/3.jpg"></div>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<script>
    var mySwiper = new Swiper ('.swiper-container', {
        loop:true,

        autoplay: {
            delay:4000,
            disableOnInteraction: false,
        },

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    })
</script>