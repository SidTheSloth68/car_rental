<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Rentaly') }} - Login</title>
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Rentaly - Multipurpose Vehicle Car Rental Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet" type="text/css" id="mdb">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
    <!-- font awesome -->
    <link href="{{ asset('fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        
        <!-- page preloader begin -->
        <div id="de-preloader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
        @include('components.header')
        <!-- header close -->
        
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <section id="section-hero" aria-label="section" class="jarallax">
                <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
                <div class="v-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-4 offset-lg-4">
                                <div class="padding40 rounded-3 shadow-soft" data-bgcolor="#ffffff">
                                    <h4>Login</h4>
                                    <div class="spacer-10"></div>
                                    
                                    <!-- Session Status -->
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="form-border">
                                        @csrf
                                        
                                        <div class="field-set">
                                            <input type="email" 
                                                   name="email" 
                                                   id="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   placeholder="Your Email" 
                                                   value="{{ old('email') }}" 
                                                   required 
                                                   autofocus 
                                                   autocomplete="username" />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="field-set">
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Your Password" 
                                                   required 
                                                   autocomplete="current-password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="field-set">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                                <label class="form-check-label" for="remember_me">
                                                    {{ __('Remember me') }}
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div id="submit">
                                            <input type="submit" id="send_message" value="Sign In" class="btn-main btn-fullwidth rounded-3" />
                                        </div>
                                    </form>

                                    <div class="spacer-20"></div>
                                    
                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                    </div>

                                    <div class="spacer-10"></div>
                                    
                                    <div class="text-center">
                                        <span>Don't have an account? </span>
                                        <a href="{{ route('register') }}" class="text-decoration-none color-2">
                                            Register here
                                        </a>
                                    </div>

                                    <div class="title-line">Or&nbsp;sign&nbsp;in&nbsp;with</div>
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <a class="btn-sc btn-fullwidth mb10" href="#"><img src="{{ asset('images/svg/google_icon.svg') }}" alt="">Google</a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a class="btn-sc btn-fullwidth mb10" href="#"><img src="{{ asset('images/svg/facebook_icon.svg') }}" alt="">Facebook</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->

        @include('components.footer')
    </div>
    
    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

</body>

</html>
