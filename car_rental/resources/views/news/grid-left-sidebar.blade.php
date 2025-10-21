@extends('layouts.app')

@section('title', 'News & Updates - Grid Left Sidebar')

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
            <div class="col-lg-4">
                <!-- Recent Posts Widget -->
                <div class="widget widget-post">
                    <h4>Recent Posts</h4>
                    <div class="small-border"></div>
                    <ul class="de-bloglist-type-1">
                        @foreach($recentNews as $recent)
                        <li>
                            <div class="d-image">
                                <img src="{{ $recent->featured_image ? asset($recent->featured_image) : asset('images/news-thumbnail/pic-blog-1.jpg') }}" alt="{{ $recent->title }}">
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
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'car-rental']) }}">car rental</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'travel']) }}">travel</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'tips']) }}">tips</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'destinations']) }}">destinations</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'guides']) }}">guides</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'reviews']) }}">reviews</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'industry']) }}">industry</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'news']) }}">news</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'events']) }}">events</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'offers']) }}">offers</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'tourism']) }}">tourism</a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'vacation']) }}">vacation</a></li>
                    </ul>
                </div>

                <!-- Categories Widget -->
                <div class="widget widget_categories">
                    <h4>Categories</h4>
                    <div class="small-border"></div>
                    <ul>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'car-rental']) }}">Car Rental <span>({{ $categoryCounts['car-rental'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'travel']) }}">Travel Tips <span>({{ $categoryCounts['travel'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'destinations']) }}">Destinations <span>({{ $categoryCounts['destinations'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'guides']) }}">Travel Guides <span>({{ $categoryCounts['guides'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'reviews']) }}">Reviews <span>({{ $categoryCounts['reviews'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'industry']) }}">Industry News <span>({{ $categoryCounts['industry'] ?? 0 }})</span></a></li>
                        <li><a href="{{ route('news.grid-left-sidebar', ['category' => 'events']) }}">Events <span>({{ $categoryCounts['events'] ?? 0 }})</span></a></li>
                    </ul>
                </div>

                <!-- Testimonials Widget -->
                <div class="widget">
                    <h4>What Our Clients Say</h4>
                    <div class="small-border"></div>
                    <div class="owl-carousel owl-theme" id="testimonial-carousel">
                        <div class="item">
                            <div class="de_testi type-2">
                                <blockquote>
                                    <h4>Excellent Service!</h4>
                                    <p>Great support, like i have never seen before. Thanks to the support team, they are very helpful. This company provides customers great solution, that makes them best.</p>
                                    <div class="de_testi_by">
                                        <img alt="" class="rounded-circle" src="{{ asset('images/people/1.jpg') }}"> <span>John, Pixar Studio</span>
                                    </div>
                                </blockquote>
                            </div>
                        </div>
                        <div class="item">
                            <div class="de_testi type-2">
                                <blockquote>
                                    <h4>Outstanding Experience!</h4>
                                    <p>Great support, like i have never seen before. Thanks to the support team, they are very helpful. This company provides customers great solution, that makes them best.</p>
                                    <div class="de_testi_by">
                                        <img alt="" class="rounded-circle" src="{{ asset('images/people/2.jpg') }}"> <span>Sarah, Microsoft</span>
                                    </div>
                                </blockquote>
                            </div>
                        </div>
                        <div class="item">
                            <div class="de_testi type-2">
                                <blockquote>
                                    <h4>Highly Recommended!</h4>
                                    <p>Great support, like i have never seen before. Thanks to the support team, they are very helpful. This company provides customers great solution, that makes them best.</p>
                                    <div class="de_testi_by">
                                        <img alt="" class="rounded-circle" src="{{ asset('images/people/3.jpg') }}"> <span>Michael, Apple</span>
                                    </div>
                                </blockquote>
                            </div>
                        </div>
                        <div class="item">
                            <div class="de_testi type-2">
                                <blockquote>
                                    <h4>Perfect Service!</h4>
                                    <p>Great support, like i have never seen before. Thanks to the support team, they are very helpful. This company provides customers great solution, that makes them best.</p>
                                    <div class="de_testi_by">
                                        <img alt="" class="rounded-circle" src="{{ asset('images/people/4.jpg') }}"> <span>Thomas, Samsung</span>
                                    </div>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
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
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize testimonial carousel
    $('#testimonial-carousel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        nav: false,
        dots: true,
        responsive: {
            0: { items: 1 },
            768: { items: 1 },
            1024: { items: 1 }
        }
    });
});
</script>
@endpush
@endsection
