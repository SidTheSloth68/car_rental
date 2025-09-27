@extends('layouts.app')

@section('title', 'My Favorite Cars')

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
                        <h1>My Favorite Cars</h1>
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
                            <li><a href="{{ route('dashboard.profile') }}"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="{{ route('dashboard.bookings') }}"><i class="fa fa-calendar"></i>My Orders</a></li>
                            <li><a href="{{ route('dashboard.favorites') }}" class="active"><i class="fa fa-car"></i>My Favorite Cars</a></li>
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
                    @if(count($favoriteCars) > 0)
                        @foreach($favoriteCars as $car)
                        <div class="de-item-list no-border mb30">
                            <div class="d-img">
                                <img src="{{ asset($car['image']) }}" class="img-fluid" alt="{{ $car['name'] }}">
                            </div>
                            <div class="d-info">
                                <div class="d-text">
                                    <h4>{{ $car['name'] }}</h4>
                                    <div class="d-atr-group">
                                        <ul class="d-atr">
                                            <li><span>Seats:</span>{{ $car['seats'] }}</li>
                                            <li><span>Luggage:</span>{{ $car['luggage'] }}</li>
                                            <li><span>Doors:</span>{{ $car['doors'] }}</li>
                                            <li><span>Fuel:</span>{{ $car['fuel'] }}</li>
                                            <li><span>Horsepower:</span>{{ $car['horsepower'] }}</li>
                                            <li><span>Engine:</span>{{ $car['engine'] }}</li>
                                            <li><span>Drive:</span>{{ $car['drive'] }}</li>
                                            <li><span>Type:</span>{{ $car['type'] }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="d-price">
                                Daily rate from <span>${{ $car['daily_rate'] }}</span>
                                <a class="btn-main" href="#">Rent Now</a>
                                <a class="btn btn-outline-danger btn-sm ms-2" href="#" onclick="removeFavorite({{ $car['id'] ?? 0 }})">
                                    <i class="fa fa-heart-o"></i> Remove
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                    @else
                        <div class="card p-4 rounded-5 text-center">
                            <div class="py-5">
                                <i class="fa fa-heart-o fa-5x text-muted mb-4"></i>
                                <h4 class="text-muted">No Favorite Cars Yet</h4>
                                <p class="text-gray">You haven't added any cars to your favorites list. Browse our car collection and add your preferred vehicles to see them here.</p>
                                <a href="{{ route('cars.index') }}" class="btn-main mt-3">Browse Cars</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
<!-- content close -->

<script>
function removeFavorite(carId) {
    if (confirm('Are you sure you want to remove this car from your favorites?')) {
        // AJAX call to remove favorite (will be implemented when favorites system is built)
        console.log('Remove favorite car with ID:', carId);
        // For now, just reload the page
        location.reload();
    }
}
</script>
@endsection