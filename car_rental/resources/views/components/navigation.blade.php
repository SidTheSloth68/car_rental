<ul id="mainmenu">
    <li><a class="menu-item" href="{{ route('home') }}">Home</a>
        <ul>
            <li><a class="menu-item" href="{{ route('home') }}">Homepage 1</a></li>
            <li><a class="menu-item" href="#">Homepage 2</a></li>
            <li><a class="menu-item" href="#">Homepage 3</a></li>
            <li><a class="menu-item" href="#">New: Homepage 4</a></li>
            <li><a class="menu-item" href="#">New: Homepage 5</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="#">Cars</a>
        <ul>
            <li><a class="menu-item" href="#">Cars List 1</a></li>
            <li><a class="menu-item" href="#">Cars List 2</a></li>
            <li><a class="menu-item" href="#">Car Single</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="{{ route('booking.create') }}">Booking</a>
        <ul>
            <li><a class="menu-item" href="{{ route('booking.create') }}">Booking Form</a></li>
            <li><a class="menu-item" href="{{ route('booking.quick') }}">Quick Booking</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="#">My Account</a>
        <ul>
            <li><a class="menu-item" href="#">Dashboard</a></li>
            <li><a class="menu-item" href="#">My Profile</a></li>
            <li><a class="menu-item" href="#">My Orders</a></li>
            <li><a class="menu-item" href="#">Favorites</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="#">Pages</a>
        <ul>
            <li><a class="menu-item" href="{{ route('about') }}">About Us</a></li>
            <li><a class="menu-item" href="{{ route('contact.show') }}">Contact</a></li>
            <li><a class="menu-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="menu-item" href="{{ route('register') }}">Register</a></li>
            <li><a class="menu-item" href="#">404</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="{{ route('news.index') }}">News</a>
        <ul>
            <li><a class="menu-item" href="{{ route('news.index') }}">All News</a></li>
            <li><a class="menu-item" href="{{ route('news.external') }}">Live Car News (API)</a></li>
            <li><a class="menu-item" href="{{ route('news.grid-no-sidebar') }}">Grid View</a></li>
            <li><a class="menu-item" href="{{ route('news.standard-no-sidebar') }}">List View</a></li>
        </ul>
    </li>
    <li><a class="menu-item" href="#">Elements</a>
        <ul>
            <li><a class="menu-item" href="#">Alerts</a></li>
            <li><a class="menu-item" href="#">Buttons</a></li>
            <li><a class="menu-item" href="#">Icon Boxes</a></li>
            <li><a class="menu-item" href="#">Badge</a></li>
            <li><a class="menu-item" href="#">Tabs</a></li>
            <li><a class="menu-item" href="#">Accordions</a></li>
            <li><a class="menu-item" href="#">Testimonials</a></li>
            <li><a class="menu-item" href="#">Progress Bar</a></li>
            <li><a class="menu-item" href="#">Modal</a></li>
        </ul>
    </li>
</ul>