@extends('layouts.app')

@section('title', 'Forgot Password - Caravel')
@section('description', 'Reset your password to access your Caravel account')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Forgot Password</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<section id="section-login" class="bg-gray-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de_form form-border">
                            <h3>Reset Password</h3>
                            
                            <div class="mb-4 text-sm">
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </div>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="field-set">
                                    <label>Email Address:</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="spacer-single"></div>

                                <input type="submit" id="send-message" value="Email Password Reset Link" class="btn-main color-2">

                                <div class="spacer-single"></div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}">Back to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
