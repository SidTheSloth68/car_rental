@extends('layouts.app')

@section('title', 'Dashboard')

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
                        <h1>Dashboard</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- section close -->

    <section id="section-cars" class="bg-gray-100">
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
                                    {{ $user->name }}                                                
                                    <span class="profile_username text-gray">{{ $user->email }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="spacer-20"></div>
                        <ul class="menu-col">
                            <li><a href="{{ route('dashboard') }}" class="active"><i class="fa fa-home"></i>Dashboard</a></li>
                            <li><a href="{{ route('dashboard.profile') }}"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="{{ route('dashboard.bookings') }}"><i class="fa fa-calendar"></i>My Orders</a></li>
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
                    <div class="row">
                        <div class="col-lg-3 col-6 mb25 order-sm-1">
                            <div class="card p-4 rounded-5">
                                <div class="symbol mb40">
                                    <i class="fa id-color fa-2x fa-calendar-check-o"></i>
                                </div>
                                <span class="h1 mb0">{{ $stats['upcoming_orders'] }}</span>
                                <span class="text-gray">Upcoming Orders</span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 mb25 order-sm-1">
                            <div class="card p-4 rounded-5">
                                <div class="symbol mb40">
                                    <i class="fa id-color fa-2x fa-tags"></i>
                                </div>
                                <span class="h1 mb0">{{ $stats['coupons'] }}</span>
                                <span class="text-gray">Coupons</span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 mb25 order-sm-1">
                            <div class="card p-4 rounded-5">
                                <div class="symbol mb40">
                                    <i class="fa id-color fa-2x fa-calendar"></i>
                                </div>
                                <span class="h1 mb0">{{ $stats['total_orders'] }}</span>
                                <span class="text-gray">Total Orders</span>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6 mb25 order-sm-1">
                            <div class="card p-4 rounded-5">
                                <div class="symbol mb40">
                                    <i class="fa id-color fa-2x fa-calendar-times-o"></i>
                                </div>
                                <span class="h1 mb0">{{ $stats['cancelled_orders'] }}</span>
                                <span class="text-gray">Cancel Orders</span>
                            </div>
                        </div>
                    </div>

                    <div class="card p-4 rounded-5 mb25">
                        <h4>My Recent Orders</h4>

                        <table class="table de-table">
                            <thead>
                                <tr>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Order ID</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Car Name</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Pick Up Location</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Drop Off Location</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Pick Up Date</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Return Date</span></th>
                                    <th scope="col"><span class="text-uppercase fs-12 text-gray">Status</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td><span class="d-lg-none d-sm-block">Order ID</span><div class="badge bg-gray-100 text-dark">{{ $order['id'] }}</div></td>
                                    <td><span class="d-lg-none d-sm-block">Car Name</span><span class="bold">{{ $order['car_name'] }}</span></td>
                                    <td><span class="d-lg-none d-sm-block">Pick Up Location</span>{{ $order['pickup_location'] }}</td>
                                    <td><span class="d-lg-none d-sm-block">Drop Off Location</span>{{ $order['dropoff_location'] }}</td>
                                    <td><span class="d-lg-none d-sm-block">Pick Up Date</span>{{ $order['pickup_date'] }}</td>
                                    <td><span class="d-lg-none d-sm-block">Return Date</span>{{ $order['return_date'] }}</td>
                                    <td>
                                        @if($order['status'] == 'completed')
                                            <div class="badge rounded-pill bg-success">completed</div>
                                        @elseif($order['status'] == 'cancelled')
                                            <div class="badge rounded-pill bg-danger">cancelled</div>
                                        @elseif($order['status'] == 'scheduled')
                                            <div class="badge rounded-pill bg-warning">scheduled</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card p-4 rounded-5">
                        <h4>My Favorites</h4>
                        <div class="spacer-10"></div>
                        
                        @foreach($favoriteCars as $car)
                        <div class="de-item-list no-border mb30">
                            <div class="d-img">
                                <img src="{{ asset($car['image']) }}" class="img-fluid" alt="">
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
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- content close -->
@endsection