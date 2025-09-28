@extends('layouts.app')

@section('title', 'News & Updates - Grid Right Sidebar')

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
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<section id="section-hero" aria-label="section">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-8">
                <div class="row">
                    @forelse($news as $article)
                    <div class="col-lg-6 mb20">
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
                        <div class="text-center">
                            <h4>No news articles found</h4>
                            <p>Check back later for updates.</p>
                        </div>
                    </div>
                    @endforelse

                    <div class="spacer-single"></div>
                            
                    <!-- Pagination -->
                    @if($news->hasPages())
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
            </div>

            <div class="col-lg-4">
                <!-- Recent Posts Widget -->
                <div class="widget widget-post">
                    <h4>Recent Posts</h4>
                    <div class="small-border"></div>
                    <ul class="de-bloglist-type-1">
                        @foreach($recentNews as $recent)
                        <li>
                            <div class="d-image">
                                <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : asset('images/news-thumbnail/pic-blog-1.jpg') }}" alt="{{ $recent->title }}">
                            </div>
                            <div class="d-content">
                                <a href="{{ route('news.show', $recent->slug) }}"><h4>{{ $recent->title }}</h4></a>
                                <div class="d-date">{{ $recent->published_at->format('F d, Y') }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Popular Tags Widget -->
                <div class="widget widget_tags">
                    <h4>Popular Tags</h4>
                    <div class="small-border"></div>
                    <ul>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'car-rental']) }}">car rental</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'travel']) }}">travel</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'tips']) }}">tips</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'destinations']) }}">destinations</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'guides']) }}">guides</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'reviews']) }}">reviews</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'industry']) }}">industry</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'news']) }}">news</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'events']) }}">events</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'offers']) }}">offers</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'tourism']) }}">tourism</a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'vacation']) }}">vacation</a></li>
                    </ul>
                </div>

                <!-- Categories Widget -->
                <div class="widget widget_categories">
                    <h4>Categories</h4>
                    <div class="small-border"></div>
                    <ul>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'car-rental']) }}">Car Rental <span>({{ $categoryCounts['car-rental'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'travel']) }}">Travel Tips <span>({{ $categoryCounts['travel'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'destinations']) }}">Destinations <span>({{ $categoryCounts['destinations'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'guides']) }}">Travel Guides <span>({{ $categoryCounts['guides'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'reviews']) }}">Reviews <span>({{ $categoryCounts['reviews'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'industry']) }}">Industry News <span>({{ $categoryCounts['industry'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-right-sidebar', ['category' => 'events']) }}">Events <span>({{ $categoryCounts['events'] ?? 0 }})</span></a></li>
                    </ul>
                </div>

                <!-- Search Widget -->
                <div class="widget widget-search">
                    <h4>Search News</h4>
                    <div class="small-border"></div>
                    <form action="{{ route('news.grid-right-sidebar') }}" method="GET">
                        <div class="input-group">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search articles..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Archive Widget -->
                <div class="widget widget_archive">
                    <h4>Archives</h4>
                    <div class="small-border"></div>
                    <ul>
                        @foreach($archives as $archive)
                        <li>
                            <a href="{{ route('news.grid-right-sidebar', ['month' => $archive->month, 'year' => $archive->year]) }}">
                                {{ $archive->month_name }} {{ $archive->year }} 
                                <span>({{ $archive->count }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Newsletter Widget -->
                <div class="widget widget-newsletter">
                    <h4>Newsletter</h4>
                    <div class="small-border"></div>
                    <p>Subscribe to our newsletter and get the latest updates delivered to your inbox.</p>
                    <form id="sidebar-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
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

@push('scripts')
<script>
$(document).ready(function() {
    // Newsletter subscription
    $('#sidebar-newsletter-form').on('submit', function(e) {
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
        // In real implementation, you would submit to the server
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