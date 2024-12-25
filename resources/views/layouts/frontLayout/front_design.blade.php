<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Todo App </title>

    {{-- Css Files--}}
    <link href="{{ asset('assets/css/frontend_css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/vendor/linearicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/vendor/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/plugins/animation.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/plugins/slick.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/plugins/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/plugins/easyzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend_css/style.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1855e3c73c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    @yield('css')
    {{--End Css Files--}}
</head><!--/head-->

<body data-spy="scroll" data-target=".fixed-top">
@include('layouts.frontLayout.front_header')
<div id="main-wrapper">
    <div class="site-wrapper-reveal">
             <div class="overlay"></div>
       @yield('content')
    </div>
</div>

@include('layouts.frontLayout.front_footer')


<script src="{{ asset('assets/js/frontend_js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('assets/js/frontend_js/vendor/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/frontend_js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('assets/js/frontend_js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/fullpage.min.js') }}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/slick.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/countdown.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/magnific-popup.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/easyzoom.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/images-loaded.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/isotope.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/YTplayer.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/jquery.instagramfeed.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/ajax.mail.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/plugins/wow.min.js')}}"></script>
<script src="{{ asset('assets/js/frontend_js/main.js')}}"></script>
@yield('js')
<script>
    feather.replace() ;
    $("[rel='tooltip']").tooltip();

</script>
