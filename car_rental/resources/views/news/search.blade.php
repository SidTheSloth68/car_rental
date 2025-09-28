@extends('layouts.app')

@section('title', 'Search Results - News')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Search Results</h1>
                </div>
                @if($searchTerm)
                <div class="col-lg-6 offset-lg-3">
                    <p class="lead">Results for: "<strong>{{ $searchTerm }}</strong>"</p>
                </div>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- Search Results Section -->
<section id="section-news" class="pt60 pb80" aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Search Info -->
                <div class="row align-items-center mb40">
                    <div class="col-md-8">
                        @if($searchTerm)
                            <h3>Search Results for "{{ $searchTerm }}"</h3>
                            <p class="text-muted">{{ $news->total() }} articles found</p>
                        @else
                            <h3>Search News</h3>
                            <p class="text-muted">Enter a search term to find articles</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">All News</a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="search-form-large mb40">
                    <form action="{{ route('news.search') }}" method="GET" class="form-border">
                        <div class="row">
                            <div class="col-md-8 mb20">
                                <input type="text" 
                                       name="q" 
                                       class="form-control form-control-lg" 
                                       placeholder="Search news articles..." 
                                       value="{{ $searchTerm }}"
                                       required>
                            </div>
                            <div class="col-md-4 mb20">
                                <select name="category" class="form-control form-control-lg">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $key => $name)
                                    <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn-main btn-lg">
                                    <i class="fa fa-search"></i> Search Articles
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Search Results -->
                @if($searchTerm)
                    @forelse($news as $article)
                    <div class="search-result-item mb40">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="result-image">
                                    <img alt="{{ $article->title }}" 
                                         src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
                                         class="img-fullwidth">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="result-content">
                                    <div class="result-meta mb10">
                                        <span class="result-category">{{ ucfirst(str_replace('-', ' ', $article->category)) }}</span>
                                        <span class="result-date">{{ $article->published_at->format('F d, Y') }}</span>
                                        <span class="result-author">By {{ $article->author->name ?? 'Admin' }}</span>
                                    </div>
                                    <h4><a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a></h4>
                                    <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 200) }}</p>
                                    <a class="btn-main" href="{{ route('news.show', $article->slug) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-results text-center py80">
                        <i class="fa fa-search fa-5x text-muted mb30"></i>
                        <h4>No Results Found</h4>
                        <p class="lead">We couldn't find any articles matching your search criteria.</p>
                        <div class="suggestions mt30">
                            <h6>Try:</h6>
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{ route('news.search', ['q' => 'travel']) }}" class="btn btn-sm btn-outline-primary">Travel</a></li>
                                <li class="list-inline-item"><a href="{{ route('news.search', ['q' => 'car rental']) }}" class="btn btn-sm btn-outline-primary">Car Rental</a></li>
                                <li class="list-inline-item"><a href="{{ route('news.search', ['q' => 'tips']) }}" class="btn btn-sm btn-outline-primary">Tips</a></li>
                            </ul>
                        </div>
                    </div>
                    @endforelse
                @endif

                <!-- Pagination -->
                @if($news->hasPages())
                <div class="spacer-single"></div>
                <div class="col-md-12">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="disabled"><span>Prev</span></li>
                        @else
                            <li><a href="{{ $news->appends(request()->query())->previousPageUrl() }}" rel="prev">Prev</a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($news->appends(request()->query())->getUrlRange(1, $news->lastPage()) as $page => $url)
                            @if ($page == $news->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($news->hasMorePages())
                            <li><a href="{{ $news->appends(request()->query())->nextPageUrl() }}" rel="next">Next</a></li>
                        @else
                            <li class="disabled"><span>Next</span></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Search Tips Widget -->
                <div class="widget">
                    <h4>Search Tips</h4>
                    <div class="small-border"></div>
                    <ul class="search-tips">
                        <li>Use specific keywords for better results</li>
                        <li>Try different combinations of words</li>
                        <li>Use category filters to narrow results</li>
                        <li>Check spelling and try synonyms</li>
                    </ul>
                </div>

                <!-- Popular Searches Widget -->
                <div class="widget">
                    <h4>Popular Searches</h4>
                    <div class="small-border"></div>
                    <div class="popular-searches">
                        <a href="{{ route('news.search', ['q' => 'car rental tips']) }}" class="search-tag">Car Rental Tips</a>
                        <a href="{{ route('news.search', ['q' => 'travel guides']) }}" class="search-tag">Travel Guides</a>
                        <a href="{{ route('news.search', ['q' => 'budget travel']) }}" class="search-tag">Budget Travel</a>
                        <a href="{{ route('news.search', ['q' => 'destinations']) }}" class="search-tag">Destinations</a>
                        <a href="{{ route('news.search', ['q' => 'road trips']) }}" class="search-tag">Road Trips</a>
                        <a href="{{ route('news.search', ['q' => 'luxury cars']) }}" class="search-tag">Luxury Cars</a>
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="widget widget_categories">
                    <h4>Browse Categories</h4>
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
                    <p>Get the latest articles delivered to your inbox.</p>
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
.search-form-large {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #eee;
}

.search-result-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 30px;
}

.result-meta span {
    margin-right: 15px;
    font-size: 14px;
    color: #666;
}

.result-category {
    background: #007bff;
    color: white !important;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 12px;
}

.search-tips {
    list-style: none;
    padding: 0;
}

.search-tips li {
    padding: 5px 0;
    border-bottom: 1px solid #f0f0f0;
    color: #666;
}

.search-tips li:before {
    content: "💡";
    margin-right: 10px;
}

.popular-searches {
    margin-top: 15px;
}

.search-tag {
    display: inline-block;
    background: #f8f9fa;
    color: #666;
    padding: 5px 12px;
    margin: 3px 5px 3px 0;
    border-radius: 15px;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.search-tag:hover {
    background: #007bff;
    color: white;
    text-decoration: none;
}

.no-results {
    background: #f8f9fa;
    border-radius: 10px;
}

.suggestions h6 {
    margin-bottom: 15px;
    color: #333;
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

    // Auto-focus search input
    $('input[name="q"]').focus();
});
</script>
@endpush
@endsection