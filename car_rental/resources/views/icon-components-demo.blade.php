@extends('layouts.app')

@section('title', 'Icon Components Demo - Caravel')
@section('description', 'Showcase of Caravel icon components including Elegant Icons, ET-Line Icons, and Font Awesome icons')

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
                                <h1>Icon Components</h1>
                                <p class="lead">Beautiful icons for every need</p>
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
                        <div class="col-md-12">
                            <h2>Font Awesome Icons</h2>
                            <p>Comprehensive icon library with multiple styles and animations.</p>
                            
                            <div class="mb-4">
                                <h5>Basic Icons</h5>
                                @include('components.icons.fontawesome', ['icon' => 'home', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'user', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'heart', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'star', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'phone', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'envelope', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'calendar', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Icon Styles</h5>
                                <div class="mb-2">
                                    <strong>Solid:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'heart', 'style' => 'solid', 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.fontawesome', ['icon' => 'star', 'style' => 'solid', 'class' => 'me-3', 'color' => 'warning'])
                                    @include('components.icons.fontawesome', ['icon' => 'thumbs-up', 'style' => 'solid', 'class' => 'me-3', 'color' => 'success'])
                                </div>
                                <div class="mb-2">
                                    <strong>Regular:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'heart', 'style' => 'regular', 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.fontawesome', ['icon' => 'star', 'style' => 'regular', 'class' => 'me-3', 'color' => 'warning'])
                                    @include('components.icons.fontawesome', ['icon' => 'thumbs-up', 'style' => 'regular', 'class' => 'me-3', 'color' => 'success'])
                                </div>
                                <div class="mb-2">
                                    <strong>Brands:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'facebook', 'style' => 'brands', 'class' => 'me-3', 'color' => 'primary'])
                                    @include('components.icons.fontawesome', ['icon' => 'twitter', 'style' => 'brands', 'class' => 'me-3', 'color' => 'info'])
                                    @include('components.icons.fontawesome', ['icon' => 'instagram', 'style' => 'brands', 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.fontawesome', ['icon' => 'linkedin', 'style' => 'brands', 'class' => 'me-3', 'color' => 'primary'])
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Icon Sizes</h5>
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'xs', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'sm', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'md', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'lg', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'xl', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => '2xl', 'class' => 'me-3'])
                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => '3xl', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Animated Icons</h5>
                                <div class="mb-2">
                                    <strong>Spin:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'spinner', 'spin' => true, 'class' => 'me-3'])
                                    @include('components.icons.fontawesome', ['icon' => 'cog', 'spin' => true, 'class' => 'me-3'])
                                    @include('components.icons.fontawesome', ['icon' => 'refresh', 'spin' => true, 'class' => 'me-3'])
                                </div>
                                <div class="mb-2">
                                    <strong>Pulse:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'circle', 'pulse' => true, 'class' => 'me-3', 'color' => 'success'])
                                    @include('components.icons.fontawesome', ['icon' => 'heart', 'pulse' => true, 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.fontawesome', ['icon' => 'bell', 'pulse' => true, 'class' => 'me-3', 'color' => 'warning'])
                                </div>
                                <div class="mb-2">
                                    <strong>Beat:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'heart', 'beat' => true, 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.fontawesome', ['icon' => 'music', 'beat' => true, 'class' => 'me-3', 'color' => 'primary'])
                                </div>
                                <div class="mb-2">
                                    <strong>Bounce:</strong>
                                    @include('components.icons.fontawesome', ['icon' => 'arrow-up', 'bounce' => true, 'class' => 'me-3', 'color' => 'success'])
                                    @include('components.icons.fontawesome', ['icon' => 'basketball', 'bounce' => true, 'class' => 'me-3', 'color' => 'warning'])
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Icons with Backgrounds</h5>
                                <div class="mb-3">
                                    <strong>Circular Backgrounds:</strong><br>
                                    <div class="fa-icon-circle fa-icon-circle-sm fa-icon-primary me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'user'])
                                    </div>
                                    <div class="fa-icon-circle fa-icon-circle-md fa-icon-success me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'check'])
                                    </div>
                                    <div class="fa-icon-circle fa-icon-circle-lg fa-icon-danger me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'heart'])
                                    </div>
                                    <div class="fa-icon-circle fa-icon-circle-md fa-icon-warning me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'star'])
                                    </div>
                                    <div class="fa-icon-circle fa-icon-circle-md fa-icon-info me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'info'])
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Square Backgrounds:</strong><br>
                                    <div class="fa-icon-square fa-icon-square-sm fa-icon-primary me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'home'])
                                    </div>
                                    <div class="fa-icon-square fa-icon-square-md fa-icon-secondary me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'cog'])
                                    </div>
                                    <div class="fa-icon-square fa-icon-square-lg fa-icon-dark me-2">
                                        @include('components.icons.fontawesome', ['icon' => 'car'])
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Clickable Icons</h5>
                                <p>Click these icons to see the click effect:</p>
                                @include('components.icons.fontawesome', ['icon' => 'thumbs-up', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'success'])
                                @include('components.icons.fontawesome', ['icon' => 'thumbs-down', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.fontawesome', ['icon' => 'heart', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.fontawesome', ['icon' => 'bookmark', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'primary'])
                                @include('components.icons.fontawesome', ['icon' => 'share', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'info'])
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h2>Elegant Icons</h2>
                            <p>Beautiful and elegant icon set with smooth animations.</p>
                            
                            <div class="mb-4">
                                <h5>Basic Elegant Icons</h5>
                                @include('components.icons.elegant', ['icon' => 'heart', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'home', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'user', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'mail', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'phone', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'calendar', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'clock', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Elegant Icon Sizes</h5>
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => 'xs', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => 'sm', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => 'md', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => 'lg', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => 'xl', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => '2xl', 'class' => 'me-3'])
                                @include('components.icons.elegant', ['icon' => 'star', 'size' => '3xl', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Elegant Animated Icons</h5>
                                <div class="mb-2">
                                    <strong>Spin:</strong>
                                    @include('components.icons.elegant', ['icon' => 'loading', 'spin' => true, 'class' => 'me-3'])
                                    @include('components.icons.elegant', ['icon' => 'refresh', 'spin' => true, 'class' => 'me-3'])
                                </div>
                                <div class="mb-2">
                                    <strong>Pulse:</strong>
                                    @include('components.icons.elegant', ['icon' => 'heart', 'pulse' => true, 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.elegant', ['icon' => 'star', 'pulse' => true, 'class' => 'me-3', 'color' => 'warning'])
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Clickable Elegant Icons</h5>
                                @include('components.icons.elegant', ['icon' => 'like', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'success'])
                                @include('components.icons.elegant', ['icon' => 'dislike', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.elegant', ['icon' => 'heart_alt', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.elegant', ['icon' => 'bookmark_alt', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'primary'])
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h2>ET-Line Icons</h2>
                            <p>Modern line icons with smooth animations and hover effects.</p>
                            
                            <div class="mb-4">
                                <h5>Basic ET-Line Icons</h5>
                                @include('components.icons.etline', ['icon' => 'home', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'user', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'mail', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'phone', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'star', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'calendar', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'camera', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>ET-Line Icon Sizes</h5>
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => 'xs', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => 'sm', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => 'md', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => 'lg', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => 'xl', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => '2xl', 'class' => 'me-3'])
                                @include('components.icons.etline', ['icon' => 'heart', 'size' => '3xl', 'class' => 'me-3'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>ET-Line Animated Icons</h5>
                                <div class="mb-2">
                                    <strong>Spin:</strong>
                                    @include('components.icons.etline', ['icon' => 'loading', 'spin' => true, 'class' => 'me-3'])
                                    @include('components.icons.etline', ['icon' => 'refresh', 'spin' => true, 'class' => 'me-3'])
                                </div>
                                <div class="mb-2">
                                    <strong>Pulse:</strong>
                                    @include('components.icons.etline', ['icon' => 'heart', 'pulse' => true, 'class' => 'me-3', 'color' => 'danger'])
                                    @include('components.icons.etline', ['icon' => 'star', 'pulse' => true, 'class' => 'me-3', 'color' => 'warning'])
                                </div>
                                <div class="mb-2">
                                    <strong>Bounce:</strong>
                                    @include('components.icons.etline', ['icon' => 'up', 'bounce' => true, 'class' => 'me-3', 'color' => 'success'])
                                    @include('components.icons.etline', ['icon' => 'target', 'bounce' => true, 'class' => 'me-3', 'color' => 'primary'])
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>ET-Line Icons with Circular Background</h5>
                                <div class="etline-container etline-circle etline-circle-sm me-2">
                                    @include('components.icons.etline', ['icon' => 'user'])
                                </div>
                                <div class="etline-container etline-circle etline-circle-md me-2">
                                    @include('components.icons.etline', ['icon' => 'heart'])
                                </div>
                                <div class="etline-container etline-circle etline-circle-lg me-2">
                                    @include('components.icons.etline', ['icon' => 'star'])
                                </div>
                                <div class="etline-container etline-circle etline-circle-md me-2">
                                    @include('components.icons.etline', ['icon' => 'mail'])
                                </div>
                                <div class="etline-container etline-circle etline-circle-md me-2">
                                    @include('components.icons.etline', ['icon' => 'phone'])
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Clickable ET-Line Icons</h5>
                                @include('components.icons.etline', ['icon' => 'like', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'success'])
                                @include('components.icons.etline', ['icon' => 'dislike', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.etline', ['icon' => 'heart', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'danger'])
                                @include('components.icons.etline', ['icon' => 'bookmark', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'primary'])
                                @include('components.icons.etline', ['icon' => 'share', 'clickable' => true, 'class' => 'me-3', 'size' => 'lg', 'color' => 'info'])
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h2>Icon Usage Examples</h2>
                            <p>Real-world examples of how to use these icons in your interface.</p>
                            
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="fa-icon-circle fa-icon-circle-lg fa-icon-primary mb-3">
                                                @include('components.icons.fontawesome', ['icon' => 'car', 'size' => 'xl'])
                                            </div>
                                            <h5 class="card-title">Car Rental</h5>
                                            <p class="card-text">Find the perfect car for your journey with our extensive fleet.</p>
                                            <button class="btn btn-primary">
                                                @include('components.icons.fontawesome', ['icon' => 'search', 'class' => 'me-2'])
                                                Browse Cars
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="etline-container etline-circle etline-circle-lg mb-3">
                                                @include('components.icons.etline', ['icon' => 'calendar', 'size' => 'xl'])
                                            </div>
                                            <h5 class="card-title">Easy Booking</h5>
                                            <p class="card-text">Book your car rental in just a few simple steps online.</p>
                                            <button class="btn btn-success">
                                                @include('components.icons.elegant', ['icon' => 'calendar', 'class' => 'me-2'])
                                                Book Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="fa-icon-circle fa-icon-circle-lg fa-icon-success mb-3">
                                                @include('components.icons.fontawesome', ['icon' => 'shield-halved', 'size' => 'xl'])
                                            </div>
                                            <h5 class="card-title">Safe & Secure</h5>
                                            <p class="card-text">Your safety is our priority with comprehensive insurance coverage.</p>
                                            <button class="btn btn-info">
                                                @include('components.icons.fontawesome', ['icon' => 'info-circle', 'class' => 'me-2'])
                                                Learn More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <h6>
                                            @include('components.icons.fontawesome', ['icon' => 'lightbulb', 'class' => 'me-2'])
                                            Pro Tip
                                        </h6>
                                        <p class="mb-0">Icons can be combined with JavaScript to create interactive elements. Click any clickable icon above to see custom events in action!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Listen for custom icon click events
    document.addEventListener('fontawesome-icon-click', function(event) {
        console.log('FontAwesome icon clicked:', event.detail);
        showToast('FontAwesome Icon Clicked!', `You clicked the ${event.detail.icon} icon`, 'success');
    });
    
    document.addEventListener('elegant-icon-click', function(event) {
        console.log('Elegant icon clicked:', event.detail);
        showToast('Elegant Icon Clicked!', `You clicked the ${event.detail.icon} icon`, 'info');
    });
    
    document.addEventListener('etline-icon-click', function(event) {
        console.log('ET-Line icon clicked:', event.detail);
        showToast('ET-Line Icon Clicked!', `You clicked the ${event.detail.icon} icon`, 'warning');
    });
    
    // Simple toast notification function
    function showToast(title, message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} position-fixed`;
        toast.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 250px;
            animation: slideInRight 0.3s ease-out;
        `;
        toast.innerHTML = `
            <strong>${title}</strong><br>
            ${message}
            <button type="button" class="btn-close float-end" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }
    
    // Add CSS for toast animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>

@endsection