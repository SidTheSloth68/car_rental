<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow">
        <meta name="author" content="Rentaly Car Rental">
        
        <!-- Performance optimization -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no">
        
        <!-- PWA Configuration -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#007bff">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Rentaly">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', config('app.name', 'Rentaly'))">
        <meta property="og:description" content="@yield('description', 'Premium car rental service with easy booking and great rates')">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', config('app.name', 'Rentaly'))">
        <meta property="twitter:description" content="@yield('description', 'Premium car rental service with easy booking and great rates')">
        <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

        <title>@yield('title', config('app.name', 'Rentaly'))</title>
        <meta name="description" content="@yield('description', 'Premium car rental service with easy booking and great rates')">
        
        <!-- Favicons -->
        <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
        <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">
        
        <!-- Preload critical resources -->
        <link rel="preload" href="{{ asset('css/style.css') }}" as="style">
        <link rel="preload" href="{{ asset('js/plugins.js') }}" as="script">
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <!-- Optimized CSS Files -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
        <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
        <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/custom-1.css') }}" rel="stylesheet" type="text/css">
        <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Dark Theme CSS -->
        <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/theme-toggle.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Topbar Alignment Fix -->
        <link href="{{ asset('css/topbar-fix.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Optimized CSS -->
        <link href="{{ asset('css/optimized.css') }}" rel="stylesheet" type="text/css">

        <!-- Laravel Vite Assets -->
        @vite(['resources/js/app.js'])
        
        <!-- Optimized JS -->
        <script src="{{ asset('js/optimized.js') }}" defer></script>
        
        @stack('styles')
    </head>
    <body @yield('body-class')>
        <div id="wrapper">
            <!-- page preloader begin -->
            <div id="de-preloader"></div>
            <!-- page preloader close -->
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <a href="#" id="back-to-top"></a>
            <!-- footer begin -->
            <footer class="text-light">
                <div class="container">
                    <div class="row g-custom-x">
                        <div class="col-lg-3">
                            <div class="widget">
                                <h5>About Caravel</h5>
                                <p>Where quality meets affordability. We understand the importance of a smooth and enjoyable journey without the burden of excessive costs. That's why we have meticulously crafted our offerings to provide you with top-notch vehicles at minimum expense.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-3">
                            <div class="widget">
                                <h5>Contact Info</h5>
                                <address class="s1">
                                    <span><i class="id-color fa fa-map-marker fa-lg"></i>08 W 36th St, New York, NY 10001</span>
                                    <span><i class="id-color fa fa-phone fa-lg"></i>+1 333 9296</span>
                                    <span><i class="id-color fa fa-envelope-o fa-lg"></i><a href="mailto:contact@example.com">contact@example.com</a></span>
                                    <span><i class="id-color fa fa-file-pdf-o fa-lg"></i><a href="#">Download Brochure</a></span>
                                </address>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <h5>Quick Links</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="widget">
                                        <ul>
                                            <li><a href="#">About</a></li>
                                            <li><a href="#">Blog</a></li>
                                            <li><a href="#">Careers</a></li>
                                            <li><a href="#">News</a></li>
                                            <li><a href="#">Partners</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="widget">
                                <h5>Social Network</h5>
                                <div class="social-icons">
                                    <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                    <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                    <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                    <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                    <a href="#"><i class="fa fa-rss fa-lg"></i></a>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="subfooter">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="de-flex">
                                    <div class="de-flex-col">
                                        <a href="{{ route('home') }}">
                                            Copyright 2025 - Caravel by BinOmar
                                        </a>
                                    </div>
                                    <ul class="menu-simple">
                                        <li><a href="#">Terms &amp; Conditions</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer close -->
        </div>

        <!-- Caravel JavaScript Files -->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/designesia.js') }}"></script>
        
        <!-- Dark Theme Manager -->
        <script src="{{ asset('js/theme-manager.js') }}"></script>
        
        <!-- Fix for menu items with submenus - allow parent link clicks -->
        <script>
        jQuery(document).ready(function($) {
            // For desktop: Allow direct click on parent menu items that have URLs
            $('#mainmenu > li > a[href]:not([href="#"])').on('click', function(e) {
                var $this = $(this);
                var href = $this.attr('href');
                
                // If clicking directly on the link text (not the arrow/span)
                if (e.target === this && href && href !== '#') {
                    // Allow navigation
                    window.location.href = href;
                    return false;
                }
            });
            
            // For mobile: ensure menu items work
            $('#mainmenu a[href]:not([href="#"])').each(function() {
                var $link = $(this);
                var href = $link.attr('href');
                
                // Add touch event for mobile
                $link.on('touchend', function(e) {
                    if (href && href !== '#' && e.target === this) {
                        e.preventDefault();
                        window.location.href = href;
                    }
                });
            });
        });
        </script>
        
        @yield('scripts')
        @stack('scripts')
    </body>
</html>
