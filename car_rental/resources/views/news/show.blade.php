@extends('layouts.app')

@section('title', $article->title . ' - News')

@section('meta_description', $article->meta_description ?: Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', $article->meta_keywords)

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>{{ $article->title }}</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- section begin -->
<section aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-read">
                    @if($article->featured_image)
                    <img alt="{{ $article->title }}" 
                         src="{{ asset($article->featured_image) }}" 
                         class="img-fullwidth mb30">
                    @endif

                    <div class="post-text">
                        <!-- Article Meta -->
                        <div class="d-meta mb30">
                            <span class="d-by">By {{ $article->author->name ?? 'Admin' }}</span>
                            <span class="d-date">{{ $article->published_at->format('F d, Y') }}</span>
                            <span class="d-tags">{{ ucfirst(str_replace('-', ' ', $article->category)) }}</span>
                            <span class="d-views">{{ number_format($article->views_count) }} views</span>
                        </div>

                        <!-- Article Content -->
                        {!! $article->content !!}

                        <!-- Article Tags -->
                        @if($article->tags && count($article->tags) > 0)
                        <div class="mt30">
                            <h5>Tags:</h5>
                            <div class="tag-list">
                                @foreach($article->tags as $tag)
                                <span class="tag-item">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Social Share -->
                <div class="spacer-single"></div>
                <div class="share-widget">
                    <h4>Share This Article</h4>
                    <div class="de-color-icons">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}" target="_blank">
                            <span><i class="fa fa-twitter fa-lg"></i></span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <span><i class="fa fa-facebook fa-lg"></i></span>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <span><i class="fa fa-linkedin fa-lg"></i></span>
                        </a>
                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($article->title) }}" target="_blank">
                            <span><i class="fa fa-pinterest fa-lg"></i></span>
                        </a>
                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(request()->fullUrl()) }}">
                            <span><i class="fa fa-envelope fa-lg"></i></span>
                        </a>
                    </div>
                </div>

                <!-- Related Articles -->
                @if($relatedArticles && $relatedArticles->count() > 0)
                <div class="spacer-single"></div>
                <div class="related-posts">
                    <h4>Related Articles</h4>
                    <div class="row">
                        @foreach($relatedArticles as $related)
                        <div class="col-md-4 mb30">
                            <div class="bloglist item">
                                <div class="post-content">
                                    <div class="post-image">
                                        <img alt="{{ $related->title }}" 
                                             src="{{ $related->featured_image ? asset($related->featured_image) : asset('images/news/pic-blog-1.jpg') }}" 
                                             class="lazy">
                                    </div>
                                    <div class="post-text">
                                        <span class="p-tagline">{{ ucfirst(str_replace('-', ' ', $related->category)) }}</span>
                                        <h4><a href="{{ route('news.show', $related->slug) }}">{{ $related->title }}</a></h4>
                                        <p>{{ Str::limit($related->excerpt ?: strip_tags($related->content), 80) }}</p>
                                        <span class="p-author">{{ $related->published_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Comments Section -->
                <div class="spacer-single"></div>
                <div id="blog-comment">
                    <h4>Comments</h4>
                    <div class="spacer-half"></div>
                    
                    <!-- Comments will be implemented later when user system is complete -->
                    <div class="comments-placeholder">
                        <p class="text-muted">Comments system will be available soon. Stay tuned!</p>
                    </div>

                    <!-- Comment Form -->
                    <div class="spacer-single"></div>
                    <div id="comment-form-wrapper">
                        <h4>Leave a Comment</h4>
                        <div class="comment_form_holder">
                            <form id="comment_form" name="comment_form" class="form-border" method="post" action="#">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">

                                <label>Name <span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required />

                                <label>Email <span class="req">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" required />

                                <label>Message <span class="req">*</span></label>
                                <textarea cols="10" rows="10" name="message" id="message" class="form-control" required></textarea>

                                <p id="btnsubmit">
                                    <input type="submit" id="send" value="Post Comment" class="btn-main" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sidebar" class="col-md-4">
                <!-- Share Widget -->
                <div class="widget">
                    <h4>Share With Friends</h4>
                    <div class="small-border"></div>
                    <div class="de-color-icons">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}" target="_blank">
                            <span><i class="fa fa-twitter fa-lg"></i></span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <span><i class="fa fa-facebook fa-lg"></i></span>
                        </a>
                        <a href="https://www.reddit.com/submit?url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($article->title) }}" target="_blank">
                            <span><i class="fa fa-reddit fa-lg"></i></span>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <span><i class="fa fa-linkedin fa-lg"></i></span>
                        </a>
                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($article->title) }}" target="_blank">
                            <span><i class="fa fa-pinterest fa-lg"></i></span>
                        </a>
                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(request()->fullUrl()) }}">
                            <span><i class="fa fa-envelope fa-lg"></i></span>
                        </a>
                    </div>
                </div>

                <!-- Recent Posts Widget -->
                <div class="widget widget-post">
                    <h4>Recent Posts</h4>
                    <div class="small-border"></div>
                    <ul class="de-bloglist-type-1">
                        @foreach($recentArticles as $recent)
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

                <!-- About Widget -->
                <div class="widget widget-text">
                    <h4>About Caravel</h4>
                    <div class="small-border"></div>
                    <p class="small no-bottom">
                        Your trusted partner for car rental services. We provide reliable, affordable, and convenient car rental solutions for all your travel needs. Explore the world with confidence and comfort.
                    </p>
                </div>

                <!-- Tags Widget -->
                <div class="widget widget_tags">
                    <h4>Popular Tags</h4>
                    <div class="small-border"></div>
                    <ul>
                        <li><a href="{{ route('news.search', ['q' => 'car rental']) }}">car rental</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'travel']) }}">travel</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'tips']) }}">tips</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'destinations']) }}">destinations</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'guides']) }}">guides</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'reviews']) }}">reviews</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'industry']) }}">industry</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'tourism']) }}">tourism</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'vacation']) }}">vacation</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'adventure']) }}">adventure</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'budget']) }}">budget</a></li>
                        <li><a href="{{ route('news.search', ['q' => 'luxury']) }}">luxury</a></li>
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

@push('styles')
<style>
.d-meta {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.d-meta span {
    margin-right: 20px;
    color: #666;
    font-size: 14px;
}

.tag-list {
    margin-top: 10px;
}

.tag-item {
    display: inline-block;
    background: #f8f9fa;
    color: #666;
    padding: 5px 12px;
    margin: 3px 5px 3px 0;
    border-radius: 15px;
    font-size: 12px;
    text-transform: lowercase;
}

.share-widget {
    border: 1px solid #eee;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
}

.share-widget h4 {
    margin-bottom: 15px;
}

.de-color-icons a {
    text-decoration: none;
}

.de-color-icons span {
    display: inline-block;
    margin-right: 10px;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border-radius: 50%;
    background: #f8f9fa;
    color: #666;
    transition: all 0.3s ease;
}

.de-color-icons span:hover {
    background: #007bff;
    color: white;
    transform: translateY(-2px);
}

.related-posts {
    margin-top: 40px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}

.comments-placeholder {
    padding: 40px;
    text-align: center;
    background: #f8f9fa;
    border-radius: 5px;
}
</style>
@endpush

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
        form.find('button').text('Subscribed!').prop('disabled', true);
        setTimeout(function() {
            form.find('button').text('Subscribe').prop('disabled', false);
            form.find('input[name="email"]').val('');
        }, 3000);
    });

    // Comment form submission (placeholder)
    $('#comment_form').on('submit', function(e) {
        e.preventDefault();
        alert('Comment system will be implemented soon!');
    });

    // Social share tracking (optional)
    $('.de-color-icons a').on('click', function() {
        // You can add analytics tracking here
        console.log('Social share clicked: ' + $(this).attr('href'));
    });
});
</script>
@endpush
@endsection
