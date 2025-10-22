@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<!-- content begin -->
<div class="no-bottom no-top zebra" id="content">
    <div id="top"></div>
    
    <!-- section begin -->
    <section id="subheader" class="jarallax text-light">
        <img src="{{ asset('images/background/14.jpg') }}" class="jarallax-img" alt="">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1>My Profile</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- section close -->

    <section id="section-settings" class="bg-gray-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb30">
                    <div class="card p-4 rounded-5">
                        <div class="profile_avatar">
                            <div class="profile_img">
                                <img src="{{ asset('images/profile/1.jpg') }}" alt="">
                            </div>
                            <div class="profile_name">
                                <h4>
                                    {{ Auth::user()->name }}                                                
                                    <span class="profile_username text-gray">{{ Auth::user()->email }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="spacer-20"></div>
                        <ul class="menu-col">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>Dashboard</a></li>
                            <li><a href="{{ route('dashboard.profile') }}" class="active"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="{{ route('dashboard.favorites') }}"><i class="fa fa-car"></i>My Favorite Cars</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: inherit; text-decoration: none; cursor: pointer; padding: 0; font: inherit;">
                                        <i class="fa fa-sign-out"></i>Sign Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card p-4 rounded-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Display Success/Error Messages -->
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="form-create-item" class="form-border" method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')
                                    
                                    <div class="de_tab tab_simple">
                                        <ul class="de_nav">
                                            <li class="active"><span>Profile</span></li>
                                            <li><span>Notifications</span></li>
                                        </ul>
                                        
                                        <div class="de_tab_content">                            
                                            <div class="tab-1">
                                                <div class="row">
                                                    <div class="col-lg-6 mb20">
                                                        <h5>Name</h5>
                                                        <input type="text" name="name" id="name" class="form-control" 
                                                               placeholder="Enter your name" 
                                                               value="{{ old('name', Auth::user()->name) }}" />
                                                    </div>
                                                    <div class="col-lg-6 mb20">
                                                        <h5>Email Address</h5>
                                                        <input type="email" name="email" id="email" class="form-control" 
                                                               placeholder="Enter email" 
                                                               value="{{ old('email', Auth::user()->email) }}" />
                                                    </div>
                                                    <div class="col-lg-6 mb20">
                                                        <h5>New Password</h5>
                                                        <input type="password" name="password" id="password" class="form-control" 
                                                               placeholder="Leave blank to keep current password" />
                                                    </div>
                                                    <div class="col-lg-6 mb20">
                                                        <h5>Confirm Password</h5>
                                                        <input type="password" name="password_confirmation" id="password_confirmation" 
                                                               class="form-control" placeholder="Confirm new password" />
                                                    </div>
                                                    <div class="col-md-6 mb20">
                                                        <h5>Language</h5>
                                                        <p class="p-info">Select your preferred language.</p>
                                                        <select name="language" class="form-control">
                                                            <option value="English" {{ old('language', $user->language ?? 'English') == 'English' ? 'selected' : '' }}>English</option>
                                                            <option value="French" {{ old('language', $user->language) == 'French' ? 'selected' : '' }}>French</option>
                                                            <option value="German" {{ old('language', $user->language) == 'German' ? 'selected' : '' }}>German</option>
                                                            <option value="Japanese" {{ old('language', $user->language) == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                                            <option value="Italian" {{ old('language', $user->language) == 'Italian' ? 'selected' : '' }}>Italian</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb20">
                                                        <h5>Hour Format</h5>
                                                        <p class="p-info">Select your preferred time format.</p>
                                                        <select name="hour_format" class="form-control">
                                                            <option value="24-hour" {{ old('hour_format', $user->hour_format ?? '24-hour') == '24-hour' ? 'selected' : '' }}>24-hour</option>
                                                            <option value="12-hour" {{ old('hour_format', $user->hour_format) == '12-hour' ? 'selected' : '' }}>12-hour</option>
                                                        </select>
                                                    </div>                               
                                                </div>
                                            </div>

                                            <div class="tab-2">
                                                <div class="row">
                                                    <div class="col-md-6 mb-sm-20">
                                                        <div class="switch-with-title s2">
                                                            <h5>Discount Notifications</h5>
                                                            <div class="de-switch">
                                                                <input type="checkbox" id="notif-item-sold" class="checkbox">
                                                                <label for="notif-item-sold"></label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <p class="p-info">You'll get notification when new discounts are available.</p>
                                                        </div>

                                                        <div class="spacer-20"></div>

                                                        <div class="switch-with-title s2">
                                                            <h5>New Car Notifications</h5>
                                                            <div class="de-switch">
                                                                <input type="checkbox" id="notif-bid-activity" class="checkbox">
                                                                <label for="notif-bid-activity"></label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <p class="p-info">You'll get notification when new cars are available.</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="switch-with-title s2">
                                                            <h5>Daily Reports</h5>
                                                            <div class="de-switch">
                                                                <input type="checkbox" id="notif-auction-expiration" class="checkbox">
                                                                <label for="notif-auction-expiration"></label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <p class="p-info">We will send you a report every day.</p>
                                                        </div>

                                                        <div class="spacer-20"></div>

                                                        <div class="switch-with-title s2">
                                                            <h5>Monthly Reports</h5>
                                                            <div class="de-switch">
                                                                <input type="checkbox" id="notif-outbid" class="checkbox">
                                                                <label for="notif-outbid"></label>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <p class="p-info">We will send you a report each month.</p>
                                                        </div>
                                                    </div>

                                                    <div class="spacer-20"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-main">Update Profile</button>
                                </form>
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