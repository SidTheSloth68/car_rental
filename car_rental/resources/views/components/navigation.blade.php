<!-- Navigation Component - To be implemented -->
<nav id="mainmenu" class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <!-- Temporary navigation placeholder -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/caravel-logo.png') }}" alt="Caravel" class="logo">
        </a>
        
        <div class="navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <!-- More navigation items will be added in next commits -->
            </ul>
        </div>
    </div>
</nav>