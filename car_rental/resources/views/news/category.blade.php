@extends('layouts.app')

@section('title', $categoryName . ' - News')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>{{ $categoryName }}</h1>
                </div>
                <div class="col-lg-6 offset-lg-3">
                    <p class="lead">Browse articles in the {{ strtolower($categoryName) }} category</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- Featured Articles for this Category -->
@if($featuredNews && $featuredNews->count() > 0)
<section id="section-featured" class="pt60 pb40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>Featured {{ $categoryName }} Articles</h3>
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
                                 src="{{ $featured->featured_image ? asset($featured->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
                                 class="lazy">
                        </div>
                        <div class="post-text">
                            <span class="p-tagline">{{ $categoryName }}</span>
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

<!-- Category Articles Section -->
<section id="section-news" class="pt40 pb80" aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row align-items-center mb40">
                    <div class="col-md-8">
                        <h3>All {{ $categoryName }} Articles</h3>
                        <p class="text-muted">{{ $news->total() }} articles found</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">All Categories</a>
                    </div>
                </div>

                <!-- Articles Grid -->
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
                                         src="{{ $article->featured_image ? asset($article->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
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
                            <i class="fa fa-folder-open fa-5x text-muted mb30"></i>
                            <h4>No Articles in {{ $categoryName }}</h4>
                            <p class="lead">There are no articles in this category yet. Check back soon for updates!</p>
                            <a href="{{ route('news.index') }}" class="btn-main">Browse All News</a>
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
                <!-- Other Categories Widget -->
                <div class="widget widget_categories">
                    <h4>Other Categories</h4>
                    <div class="small-border"></div>
                    <ul>
                        @foreach(\App\Models\News::CATEGORIES as $key => $name)
                            @if($key !== $category)
                            <li><a href="{{ route('news.category', $key) }}">{{ $name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- Search Widget -->
                <div class="widget widget-search">
                    <h4>Search in {{ $categoryName }}</h4>
                    <div class="small-border"></div>
                    <form action="{{ route('news.search') }}" method="GET">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <div class="input-group">
                            <input type="text" 
                                   name="q" 
                                   class="form-control" 
                                   placeholder="Search in {{ strtolower($categoryName) }}..." 
                                   value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Layout Options Widget -->
                <div class="widget">
                    <h4>View Options</h4>
                    <div class="small-border"></div>
                    <div class="layout-options">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('news.grid-left-sidebar', ['category' => $category]) }}"><i class="fa fa-th-large"></i> Grid View</a></li>
                            <li><a href="{{ route('news.standard-left-sidebar', ['category' => $category]) }}"><i class="fa fa-list"></i> Standard View</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter Widget -->
                <div class="widget widget-newsletter">
                    <h4>Newsletter</h4>
                    <div class="small-border"></div>
                    <p>Get the latest {{ strtolower($categoryName) }} articles delivered to your inbox.</p>
                    <form id="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group mb10">
                            <input type="email" name="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <button type="submit" class="btn-main btn-fullwidth">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
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
