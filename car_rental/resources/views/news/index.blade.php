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
<section id="section-featured" class="pt80 pb40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Featured Articles</h2>
                <p class="lead">Don't miss these trending stories</p>
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
                                <div class="m">{{ $featured->published_at->format('d') }}</div>
                                <div class="d">{{ $featured->published_at->format('M') }}</div>
                            </div>
                            <img alt="{{ $featured->title }}" 
                                 src="{{ $featured->featured_image ? asset('storage/' . $featured->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
                                 class="lazy">
                        </div>
                        <div class="post-text">
                            <span class="p-tagline">{{ ucfirst(str_replace('-', ' ', $featured->category)) }}</span>
                            <h4><a href="{{ route('news.show', $featured->slug) }}">{{ $featured->title }}</a></h4>
                            <p>{{ Str::limit($featured->excerpt ?: strip_tags($featured->content), 100) }}</p>
                            <span class="p-author">By {{ $featured->author->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Main News Section -->
<section id="section-news" class="pt40 pb80" aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- News Layout Options -->
                <div class="row align-items-center mb40">
                    <div class="col-md-6">
                        <h3>Latest News</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="view-options">
                            <span class="mr-2">View:</span>
                            <a href="{{ route('news.grid-no-sidebar') }}" class="btn btn-sm btn-outline-primary">Grid</a>
                            <a href="{{ route('news.standard-no-sidebar') }}" class="btn btn-sm btn-outline-primary">List</a>
                        </div>
                    </div>
                </div>

                <!-- News Articles Grid -->
                <div class="row">
                    @forelse($news as $article)
                    <div class="col-lg-6 mb30">
                        <div class="bloglist s2 item">
                            <div class="post-content">
                                <div class="post-image">
                                    <div class="date-box">
                                        <div class="m">{{ $article->published_at->format('d') }}</div>
                                        <div class="d">{{ $article->published_at->format('M') }}</div>
                                    </div>
                                    <img alt="{{ $article->title }}" 
                                         src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
                                         class="lazy">
                                </div>
                                <div class="post-text">                           
                                    <h4><a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}<span></span></a></h4>
                                    <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}</p>
                                    <a class="btn-main" href="{{ route('news.show', $article->slug) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py80">
                            <i class="fa fa-newspaper-o fa-5x text-muted mb30"></i>
                            <h4>No News Articles Yet</h4>
                            <p class="lead">We're working on bringing you the latest news and updates. Check back soon!</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($news->hasPages())
                <div class="spacer-single"></div>
                <div class="col-md-12">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="disabled"><span>Prev</span></li>
                        @else
                            <li><a href="{{ $news->previousPageUrl() }}" rel="prev">Prev</a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                            @if ($page == $news->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($news->hasMorePages())
                            <li><a href="{{ $news->nextPageUrl() }}" rel="next">Next</a></li>
                        @else
                            <li class="disabled"><span>Next</span></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="widget widget_categories">
                    <h4>Categories</h4>
                    <div class="small-border"></div>
                    <ul>
                        @foreach($categories as $key => $name)
                        <li><a href="{{ route('news.category', $key) }}">{{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Newsletter Widget -->
                <div class="widget widget-newsletter">
                    <h4>Newsletter</h4>
                    <div class="small-border"></div>
                    <p>Subscribe to our newsletter and get the latest updates delivered to your inbox.</p>
                    <form id="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group mb10">
                            <input type="email" name="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <button type="submit" class="btn-main btn-fullwidth">Subscribe</button>
                    </form>
                </div>

                <!-- Layout Options Widget -->
                <div class="widget">
                    <h4>Browse News</h4>
                    <div class="small-border"></div>
                    <div class="layout-options">
                        <h6>Grid Layouts</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('news.grid-left-sidebar') }}"><i class="fa fa-th-large"></i> Grid - Left Sidebar</a></li>
                            <li><a href="{{ route('news.grid-right-sidebar') }}"><i class="fa fa-th-large"></i> Grid - Right Sidebar</a></li>
                            <li><a href="{{ route('news.grid-no-sidebar') }}"><i class="fa fa-th-large"></i> Grid - No Sidebar</a></li>
                        </ul>
                        
                        <h6 class="mt20">Standard Layouts</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('news.standard-left-sidebar') }}"><i class="fa fa-list"></i> Standard - Left Sidebar</a></li>
                            <li><a href="{{ route('news.standard-right-sidebar') }}"><i class="fa fa-list"></i> Standard - Right Sidebar</a></li>
                            <li><a href="{{ route('news.standard-no-sidebar') }}"><i class="fa fa-list"></i> Standard - No Sidebar</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Search Widget -->
                <div class="widget widget-search">
                    <h4>Search News</h4>
                    <div class="small-border"></div>
                    <form action="{{ route('news.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" 
                                   name="q" 
                                   class="form-control" 
                                   placeholder="Search articles..." 
                                   value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
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