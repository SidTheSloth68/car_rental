<!-- header begin -->
<header class="transparent scroll-light has-topbar">
    <div id="topbar" class="topbar-dark text-light">
        <div class="container">
            <div class="topbar-left xs-hide">
                <div class="topbar-widget"><a href="#"><i class="fa fa-phone"></i>+208 333 9296</a></div>
                <div class="topbar-widget"><a href="#"><i class="fa fa-envelope"></i>contact@caravel.com</a></div>
                <div class="topbar-widget"><a href="#"><i class="fa fa-clock-o"></i>Mon - Fri 08.00 - 18.00</a></div>
            </div>
        
            <div class="topbar-right">
                <div class="social-icons">
                    <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fa fa-youtube fa-lg"></i></a>
                    <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                    <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
                </div>
                @guest
                    <div class="topbar-widget"><a href="{{ route('login') }}">Sign In</a></div>
                    <div class="topbar-widget"><a href="{{ route('register') }}">Register</a></div>
                @endguest
                @auth
                    <div class="topbar-widget"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    @if(auth()->user()->role === 'admin')
                        <div class="topbar-widget"><a href="{{ route('admin.dashboard') }}" style="color: #ffd700;"><i class="fa fa-cog"></i> Admin Panel</a></div>
                    @endif
                    <div class="topbar-widget">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <div class="de-flex-col">
                            <!-- logo begin -->
                            <div id="logo">
                                <a href="{{ route('home') }}">
                                    <img class="logo-1" src="{{ asset('images/logo.png') }}" alt="">
                                    <img class="logo-2" src="{{ asset('images/logo-light.png') }}" alt="">
                                </a>
                            </div>
                            <!-- logo close -->
                        </div>
                    </div>
                    <div class="de-flex-col header-col-mid">
                        <ul id="mainmenu">
                            <li><a class="menu-item" href="{{ route('home') }}">Home</a></li>
                            <li><a class="menu-item" href="{{ route('cars.index') }}">Cars</a></li>
                            @auth
                                <li><a class="menu-item" href="{{ route('bookings.index') }}">My Bookings</a></li>
                            @endauth
                            <li><a class="menu-item" href="{{ route('news.index') }}">News</a></li>
                            <li><a class="menu-item" href="{{ route('contact.show') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="de-flex-col">
                        <div class="menu_side_area">
                            @guest
                                <a href="{{ route('login') }}" id="btn-login" class="btn-main">Login</a>
                            @endguest
                            <span id="menu-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header close -->
