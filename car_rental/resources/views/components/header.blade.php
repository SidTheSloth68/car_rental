<!-- header begin -->
<header class="transparent scroll-light has-topbar">
    @include('components.topbar')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <div class="de-flex-col">
                            <!-- logo begin -->
                            <div id="logo">
                                <a href="{{ route('home') }}">
                                    <img alt="Caravel" src="{{ asset('images/logo.png') }}" class="logo-1">
                                    <img alt="Caravel" src="{{ asset('images/logo-2-light.png') }}" class="logo-2">
                                </a>
                            </div>
                            <!-- logo close -->
                        </div>
                    </div>
                    <div class="de-flex-col header-col-mid">
                        @include('components.navigation')
                    </div>
                    <div class="de-flex-col">
                        <div class="menu_side_area">
                            <a href="#" class="btn-main">Sign In</a>
                            <span id="menu-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header close -->