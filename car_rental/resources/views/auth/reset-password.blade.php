@extends('layouts.app')

@section('title', 'Reset Password - Rentaly')
@section('description', 'Create a new password for your Rentaly account')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Reset Password</h1>
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
                            <h3>Create New Password</h3>
                            
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->
                                <div class="field-set">
                                    <label>Email Address:</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" required autofocus readonly>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="field-set">
                                    <label>New Password:</label>
                                    <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="field-set">
                                    <label>Confirm New Password:</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="spacer-single"></div>

                                <input type="submit" id="send-message" value="Reset Password" class="btn-main color-2">

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
