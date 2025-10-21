@extends('layouts.app')

@section('title', 'Register - Caravel')
@section('description', 'Create your Caravel account')

@section('content')
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
                <div class="center-y relative text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1>Register</h1>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
            
            <section aria-label="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <h3>Create Your Account</h3>
                            <p>Join Caravel and start your journey with us.</p>
                            
                            <!-- Rental Message -->
                            @if (request('message') === 'rent')
                                <div class="alert alert-info mb-4" role="alert" style="background-color: #d7f2fb; border: 1px solid #c4ecfa; color: #22738e; padding: 12px 20px; border-radius: 5px;">
                                    <i class="fa fa-info-circle"></i> <strong>You have to be signed in for renting a car.</strong> Please create an account or <a href="{{ route('login', ['message' => 'rent']) }}" style="color: #22738e; text-decoration: underline;">sign in</a>.
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('register') }}" class="form-border">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   placeholder="Your Name" 
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autofocus 
                                                   autocomplete="name" />
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <input type="email" 
                                                   name="email" 
                                                   id="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   placeholder="Your Email" 
                                                   value="{{ old('email') }}" 
                                                   required 
                                                   autocomplete="username" />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Your Password" 
                                                   required 
                                                   autocomplete="new-password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="field-set">
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   id="password_confirmation" 
                                                   class="form-control" 
                                                   placeholder="Confirm Password" 
                                                   required 
                                                   autocomplete="new-password" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="field-set">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                                <label class="form-check-label" for="terms">
                                                    I agree to the <a href="#" class="text-decoration-none">Terms & Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div id="submit">
                                            <input type="submit" id="send_message" value="Create Account" class="btn-main btn-fullwidth rounded-3" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="spacer-single"></div>
                            
                            <div class="text-center">
                                <span>Already have an account? </span>
                                <a href="{{ route('login') }}" class="text-decoration-none color-2">
                                    Sign in here
                                </a>
                            </div>
                            
                            <div class="title-line">Or&nbsp;register&nbsp;with</div>
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
            </section>
        </div>
        <!-- content close -->
@endsection