@extends('layouts.app')

@section('title', 'News & Updates - Standard No Sidebar')

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
                    <p class="lead">Stay updated with the latest news, travel tips, and industry insights from the world of car rentals and travel.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<section id="section-content" aria-label="section">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-10 offset-lg-1">
                @forelse($news as $article)
                <div class="de-post-type-1">
                    <div class="d-image">
                        <img alt="{{ $article->title }}" 
                             src="{{ $article->featured_image ? asset($article->featured_image) : asset('images/news-2/pic-blog-1.jpg') }}" 
                             class="lazy">
                    </div>
                    <div class="d-content">
                        <div class="d-meta">
                            <span class="d-by">By {{ $article->author->name ?? 'Admin' }}</span>
                            <span class="d-date">{{ $article->published_at->format('F d, Y') }}</span>
                            <span class="d-tags">{{ ucfirst(str_replace('-', ' ', $article->category)) }}</span>
                        </div>
                        <h4><a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}<span></span></a></h4>
                        <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 250) }}</p>
                        <a href="{{ route('news.show', $article->slug) }}" class="btn-main">Read More</a>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <h4>No news articles found</h4>
                    <p>Check back later for updates.</p>
                </div>
                @endforelse
            </div>
        </div>

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
</section>

<!-- Featured Articles Section -->
<section id="section-featured" class="bg-color-2 pt40 pb40 text-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>Featured Articles</h3>
                <p class="lead">Don't miss these popular articles from our collection</p>
                <div class="spacer-20"></div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredNews ?? [] as $featured)
            <div class="col-lg-4 mb30">
                <div class="bloglist item">
                    <div class="post-content">
                        <div class="post-image">
                            <img alt="{{ $featured->title }}" 
                                 src="{{ $featured->featured_image ? asset($featured->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
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

<!-- Newsletter Section -->
<section id="section-call-to-action" class="bg-color text-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <h3>Stay Updated with Our Newsletter</h3>
                <p class="lead">Get the latest news, travel tips, and exclusive offers delivered directly to your inbox.</p>
                <form id="newsletter-form" class="row" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="col-lg-8 mb10">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-lg-4 mb10">
                        <button type="submit" class="btn-main btn-fullwidth">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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
