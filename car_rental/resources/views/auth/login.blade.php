@extends('layouts.app')

@section('title', 'Login - Caravel')
@section('description', 'Sign in to your Caravel account')

@section('content')
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
                                    
                                    <!-- Rental Message -->
                                    @if (request('message') === 'rent')
                                        <div class="alert alert-info mb-4" role="alert" style="background-color: #d7f2fb; border: 1px solid #c4ecfa; color: #22738e; padding: 12px 20px; border-radius: 5px;">
                                            <i class="fa fa-info-circle"></i> <strong>You have to be signed in for renting a car</strong>
                                        </div>
                                    @endif
                                    
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
                                        <span>Don't have an account? </span>
                                        <a href="{{ route('register') }}{{ request('message') ? '?message=' . request('message') : '' }}" class="text-decoration-none color-2">
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
@endsection
