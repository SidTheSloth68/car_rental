<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <meta name="description" content="@yield('description', 'Car rental service')">
        <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">

        <!-- Rentaly CSS Files -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
        <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
        <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
        <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">

        <!-- Laravel Vite Assets - Only JS, CSS disabled to prevent Tailwind conflicts -->
        @vite(['resources/js/app.js'])
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
                                <h5>About Rentaly</h5>
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
                                            Copyright 2025 - Rentaly by Designesia
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

        <!-- Rentaly JavaScript Files -->
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/designesia.js') }}"></script>
        @yield('scripts')
    </body>
</html>
