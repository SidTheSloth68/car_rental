@extends('layouts.app')

@section('title', 'Dark Theme Demo - Caravel')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Dark Theme Demo</h1>
                    <p class="lead">Experience Caravel in dark mode</p>
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
            <div class="col-lg-8 offset-lg-2">
                <div class="text-center mb60">
                    <h2>Dark Theme Features</h2>
                    <p class="lead">Toggle between light and dark themes with a single click. The theme preference is automatically saved and synchronized across browser tabs.</p>
                </div>

                <!-- Theme Controls -->
                <div class="row mb60">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <h4>Theme Controls</h4>
                            <p>Use the floating toggle button on the right side of your screen, or try these manual controls:</p>
                            
                            <div class="d-flex gap-3 mb-3">
                                <button class="btn btn-primary" onclick="CaravelTheme.setTheme('light')">
                                    <i class="fa fa-sun-o"></i> Light Theme
                                </button>
                                <button class="btn btn-secondary" onclick="CaravelTheme.setTheme('dark')">
                                    <i class="fa fa-moon-o"></i> Dark Theme
                                </button>
                                <button class="btn btn-outline-primary" onclick="CaravelTheme.setTheme('auto')">
                                    <i class="fa fa-adjust"></i> Auto Theme
                                </button>
                            </div>
                            
                            <div class="alert alert-info">
                                <strong>Keyboard Shortcut:</strong> Press <kbd>Ctrl + Shift + D</kbd> (or <kbd>Cmd + Shift + D</kbd> on Mac) to quickly toggle themes.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Content -->
                <div class="row mb60">
                    <div class="col-md-6">
                        <div class="card p-4 mb-4">
                            <h5>Sample Card</h5>
                            <p>This is a sample card to demonstrate how the dark theme affects different UI elements.</p>
                            <button class="btn btn-main">Primary Button</button>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card p-4 mb-4">
                            <h5>Form Elements</h5>
                            <form>
                                <div class="form-group mb-3">
                                    <label>Sample Input</label>
                                    <input type="text" class="form-control" placeholder="Enter text here">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Sample Select</label>
                                    <select class="form-control">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-outline-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table Example -->
                <div class="row mb60">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <h5>Sample Table</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Car Model</th>
                                        <th>Daily Rate</th>
                                        <th>Availability</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Toyota Camry</td>
                                        <td>৳4,950/day</td>
                                        <td><span class="badge bg-success">Available</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Book Now</button></td>
                                    </tr>
                                    <tr>
                                        <td>Honda Civic</td>
                                        <td>৳4,180/day</td>
                                        <td><span class="badge bg-warning">Limited</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Book Now</button></td>
                                    </tr>
                                    <tr>
                                        <td>BMW 3 Series</td>
                                        <td>৳9,350/day</td>
                                        <td><span class="badge bg-danger">Unavailable</span></td>
                                        <td><button class="btn btn-sm btn-outline-secondary" disabled>Unavailable</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="row mb60">
                    <div class="col-md-12">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">"The dark theme makes browsing so much easier on the eyes, especially during nighttime. Great implementation!"</p>
                            <footer class="blockquote-footer mt-2">
                                <cite title="Source Title">Sarah Johnson, Happy Customer</cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="text-center">
                    <h5>Explore Other Pages in Dark Theme</h5>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">Home</a>
                        <a href="/cars" class="btn btn-outline-primary">Cars</a>
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">News</a>
                        <a href="/about" class="btn btn-outline-primary">About</a>
                        <a href="/contact" class="btn btn-outline-primary">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    // Update current theme display
    function updateThemeStatus() {
        const currentTheme = CaravelTheme.getTheme();
        const isDark = CaravelTheme.isDarkMode();
        
        console.log('Current theme:', currentTheme);
        console.log('Is dark mode:', isDark);
    }
    
    // Update status on load and theme change
    updateThemeStatus();
    
    // Listen for theme changes
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn')) {
            setTimeout(updateThemeStatus, 100);
        }
    });
});
</script>
@endpush
@endsection