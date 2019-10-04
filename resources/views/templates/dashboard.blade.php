<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- JQuery 3.4.1 --}}
    <script src="{{asset('js/jquery/jquery-3.4.1.js')}}"></script>

    {{-- PopperJS --}}
    <script src="{{asset('js/popper/popper.min.js')}}"></script>

    {{-- Bootstrap --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/bootstrap/bootstrap.css')}}">
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

    {{-- Custom CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/main.css')}}">

    {{-- Dashboard CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('scss/custom/dashboard/dashboard.css')}}">

    <!-- FontAwesome icons -->
    <script src="{{asset('js/fontawesome/fontawesome.js')}}"></script>

    {{-- Loading CSS --}}
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/loading/loading-btn.css')}}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('head-options')

    <title>@yield('title', 'DASHBOARD - Bébés Lutins')</title>
</head>
<body>
    <main class='container-fluid'>
        <div class="row justify-content-md-center">
            <div class="col-lg-10 col-xl-8">
            @include('layouts.dashboard.header')
            
            <div class="row">
                
                @include('layouts.dashboard.sidenav')
                
                <div class="col-12 col-lg-9">
                    @yield('content')
                </div>
            </div>

            @include('layouts.dashboard.footer')
            </div>
        </div>
    </main>
    @include('components.dashboard.loader')
</body>
<script>
/*
 * Replace all SVG images with inline SVG
 */
 jQuery('img.svg').each(function(){
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');

});
</script>
<script>
function load_url(url){
    document.location.href=url;
}
</script>
</html>