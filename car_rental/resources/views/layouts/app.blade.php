<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Caravel - Car Rental Service')</title>
    <meta name="description" content="@yield('description', 'Premium car rental service with luxury and economy vehicles')">
    <meta name="keywords" content="@yield('keywords', 'car rental, luxury cars, economy cars, vehicle rental')">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/caravel-icon.png') }}" type="image/png">
    
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Color Scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Custom Styles -->
    @stack('styles')
</head>

<body class="@yield('body-class', '')">
    <div id="wrapper">
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->
        
        <!-- Header -->
        @include('components.header')
        
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            @yield('content')
        </div>
        <!-- content close -->
        
        <a href="#" id="back-to-top"></a>
        
        <!-- Footer -->
        @include('components.footer')
    </div>
    
    <!-- JavaScript Files -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
    
    <!-- Additional JavaScript -->
    @yield('javascript')
    
    <!-- Google Maps API (if needed) -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initPlaces" async defer></script> --}}
</body>
</html>