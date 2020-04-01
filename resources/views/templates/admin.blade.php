<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @yield('optional_css')

    <title>@yield('title', 'Administration')</title>
    <meta name="description" content="@yield('description', "Bienvenue sur votre page d'administration.")">
</head>
<body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/o3xxn1egstud8k4clezmtiocupaj5kof1ox4k1ywocrgml58/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <header class="d-flex d-lg-none fixex-top">
        @include('components.header.admin')
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="d-none d-lg-flex col-lg-2 p-0">
                @include('components.sidenav.admin')
            </div>
            <div class="col-12 col-lg-10 py-3">
                @yield('content')
            </div>
        </div>
    </div>


    <script>
    /* Replace all SVG images with inline SVG */
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

    {{-- Tiny MCE --}}
    <script>
    tinymce.init({
      selector: '.tiny-mce',
      plugins: "image"
    });
    </script>

    @yield('scripts')
</body>
</html>
