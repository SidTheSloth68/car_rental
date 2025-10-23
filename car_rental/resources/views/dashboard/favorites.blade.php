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
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <img src="{{ asset('images/profile/1.jpg') }}" alt="{{ Auth::user()->name }}">
                                @endif
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
                                            <li><span>Transmission:</span>{{ $car['drive'] }}</li>
                                            <li><span>Type:</span>{{ ucfirst(str_replace('_', ' ', $car['type'])) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="d-price">
                                Daily rate from <span>৳{{ number_format($car['daily_rate'] * 110, 0) }}</span>
                                @if($car['is_available'])
                                    <a class="btn-main" href="{{ route('cars.show', $car['id']) }}">Rent Now</a>
                                @else
                                    <span class="badge badge-danger">Unavailable</span>
                                @endif
                                <button class="btn btn-outline-danger btn-sm ms-2 remove-favorite-btn" 
                                        data-car-id="{{ $car['id'] }}">
                                    <i class="fa fa-heart"></i> Remove
                                </button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Handle remove favorite button clicks
    document.querySelectorAll('.remove-favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to remove this car from your favorites?')) {
                return;
            }
            
            const carId = this.dataset.carId;
            const carCard = this.closest('.de-item-list');
            
            fetch(`/favorites/${carId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the car card with animation
                    carCard.style.transition = 'opacity 0.3s';
                    carCard.style.opacity = '0';
                    setTimeout(() => {
                        carCard.remove();
                        
                        // Check if no more favorites
                        const remainingCards = document.querySelectorAll('.de-item-list');
                        if (remainingCards.length === 0) {
                            location.reload();
                        }
                    }, 300);
                } else {
                    alert(data.message || 'Failed to remove from favorites');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
});
</script>
@endsection