@extends('layouts.app')

@section('title', 'News & Updates')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>News &amp; Updates</h1>
                </div>
                <div class="col-lg-6 offset-lg-3">
                    <p class="lead">Stay informed with the latest travel tips, industry news, and car rental insights.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- Featured Articles Section -->
@if($featuredNews && $featuredNews->count() > 0)
<section id="section-featured" class="pt80 pb80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Latest Car News</h2>
                <p class="lead">Stay updated with trending automotive stories from around the world</p>
                <div class="spacer-20"></div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredNews as $featured)
            <div class="col-lg-4 mb30">
                <div class="bloglist item">
                    <div class="post-content">
                        <div class="post-image">
                            <div class="date-box">
                                <div class="m">{{ date('d', strtotime($featured->published_at)) }}</div>
                                <div class="d">{{ date('M', strtotime($featured->published_at)) }}</div>
                            </div>
                            @if(isset($featured->featured_image_url))
                            <img alt="{{ $featured->title }}" 
                                 src="{{ $featured->featured_image_url }}" 
                                 class="lazy"
                                 style="width: 100%; height: 250px; object-fit: cover;"
                                 onerror="this.src='{{ asset('images/news/pic-blog-1.jpg') }}'">
                            @else
                            <img alt="{{ $featured->title }}" 
                                 src="{{ asset('images/news/pic-blog-1.jpg') }}" 
                                 class="lazy">
                            @endif
                        </div>
                        <div class="post-text">
                            @if(isset($featured->external_source))
                            <span class="p-tagline">
                                <i class="fa fa-external-link"></i> {{ $featured->external_source }}
                            </span>
                            @endif
                            <h4>
                                <a href="{{ $featured->external_url ?? '#' }}" target="_blank">
                                    {{ Str::limit($featured->title, 80) }}
                                </a>
                            </h4>
                            <p>{{ Str::limit($featured->excerpt, 100) }}</p>
                            <a href="{{ $featured->external_url ?? '#' }}" 
                               target="_blank" 
                               class="btn-main btn-sm">
                                Read Full Article <i class="fa fa-external-link"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination / Load More News -->
        <div class="row mt-5">
            <div class="col-lg-12 text-center">
                <h4 class="mb-3">Explore More News</h4>
                <div class="btn-group" role="group">
                    <a href="{{ route('news.index', array_merge(request()->all(), ['page' => 1])) }}" 
                       class="btn {{ (!request('page') || request('page') == 1) ? 'btn-primary' : 'btn-outline-primary' }}">
                        Page 1
                    </a>
                    <a href="{{ route('news.index', array_merge(request()->all(), ['page' => 2])) }}" 
                       class="btn {{ request('page') == 2 ? 'btn-primary' : 'btn-outline-primary' }}">
                        Page 2
                    </a>
                    <a href="{{ route('news.index', array_merge(request()->all(), ['page' => 3])) }}" 
                       class="btn {{ request('page') == 3 ? 'btn-primary' : 'btn-outline-primary' }}">
                        Page 3
                    </a>
                    <a href="{{ route('news.index', array_merge(request()->all(), ['page' => 4])) }}" 
                       class="btn {{ request('page') == 4 ? 'btn-primary' : 'btn-outline-primary' }}">
                        Page 4
                    </a>
                    <a href="{{ route('news.index', array_merge(request()->all(), ['page' => 5])) }}" 
                       class="btn {{ request('page') == 5 ? 'btn-primary' : 'btn-outline-primary' }}">
                        Page 5
                    </a>
                </div>
                <p class="mt-3 text-muted">
                    <small>Each page loads different car news articles from trusted sources</small>
                </p>
            </div>
        </div>
    </div>
</section>
@else
<section id="section-featured" class="pt80 pb80">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <i class="fa fa-newspaper-o fa-5x text-muted mb30"></i>
                <h3>No News Available</h3>
                <p class="lead">Unable to fetch news at the moment. Please try again later.</p>
                <a href="{{ route('home') }}" class="btn-main mt-3">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Call to Action Section -->
<section id="section-call-to-action" class="bg-color-2 pt60 pb60 text-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ready to Start Your Journey?</h3>
                <p class="lead mb0">Book your perfect car rental today and explore with confidence.</p>
            </div>
            <div class="col-lg-4 text-right">
                <a href="{{ route('cars.index') }}" class="btn-main btn-lg">Browse Cars</a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.view-options .btn {
    margin-left: 5px;
}

.layout-options h6 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.layout-options ul li {
    margin-bottom: 8px;
}

.layout-options ul li a {
    color: #666;
    text-decoration: none;
    display: block;
    padding: 5px 0;
    transition: color 0.3s ease;
}

.layout-options ul li a:hover {
    color: #007bff;
}

.layout-options ul li a i {
    margin-right: 8px;
    width: 16px;
}

.empty-state {
    padding: 80px 0;
    text-align: center;
}

.empty-state i {
    margin-bottom: 30px;
}

/* Smooth fade-in animation for news articles */
.bloglist.item {
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
}

.bloglist.item:nth-child(1) { animation-delay: 0.1s; }
.bloglist.item:nth-child(2) { animation-delay: 0.2s; }
.bloglist.item:nth-child(3) { animation-delay: 0.3s; }
.bloglist.item:nth-child(4) { animation-delay: 0.4s; }
.bloglist.item:nth-child(5) { animation-delay: 0.5s; }
.bloglist.item:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading spinner */
.news-loading {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    display: none;
}

.news-loading.active {
    display: block;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth scroll to top when clicking pagination
    $('.btn-group a[href*="page="]').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        // Show loading spinner
        $('body').append('<div class="news-loading active"><div class="spinner"></div></div>');
        
        // Smooth scroll to top
        $('html, body').animate({
            scrollTop: $('#section-featured').offset().top - 100
        }, 600, function() {
            // Navigate to the page after scroll
            window.location.href = url;
        });
    });
    
    // Newsletter subscription
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var email = form.find('input[name="email"]').val();
        
        if (!email) {
            alert('Please enter your email address.');
            return;
        }
        
        // Simple email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return;
        }
        
        // For now, just show success message
        form.find('button').text('Subscribed!').prop('disabled', true);
        setTimeout(function() {
            form.find('button').text('Subscribe').prop('disabled', false);
            form.find('input[name="email"]').val('');
        }, 3000);
    });
});
</script>
@endpush
@endsection
