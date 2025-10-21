@extends('layouts.app')

@section('title', 'Latest Car News from Around the World')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Latest Car News</h1>
                </div>
                <div class="col-lg-6 offset-lg-3">
                    <p class="lead">Real-time automotive news from around the world</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<!-- News Section -->
<section id="section-news" class="pt60 pb80" aria-label="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="mb-3">
                        <h3>Trending Car News</h3>
                        @if(isset($apiResponse['totalResults']))
                        <p class="text-muted">{{ number_format($apiResponse['totalResults']) }} articles available</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left"></i> Back to Our News
                        </a>
                        @auth
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('news.import-api', ['count' => 10]) }}" class="btn btn-primary ml-2" 
                               onclick="return confirm('Import 10 latest articles to database?')">
                                <i class="fa fa-download"></i> Import Articles
                            </a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <!-- News Type Filter -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="btn-group" role="group">
                            <a href="{{ route('news.external', ['type' => 'general']) }}" 
                               class="btn {{ (!isset($type) || $type === 'general') ? 'btn-primary' : 'btn-outline-primary' }}">
                                <i class="fa fa-newspaper-o"></i> All Car News
                            </a>
                            <a href="{{ route('news.external', ['type' => 'ev']) }}" 
                               class="btn {{ (isset($type) && $type === 'ev') ? 'btn-primary' : 'btn-outline-primary' }}">
                                <i class="fa fa-bolt"></i> Electric Vehicles
                            </a>
                            <a href="{{ route('news.external', ['type' => 'reviews']) }}" 
                               class="btn {{ (isset($type) && $type === 'reviews') ? 'btn-primary' : 'btn-outline-primary' }}">
                                <i class="fa fa-star"></i> Reviews & Tests
                            </a>
                            <a href="{{ route('news.external', ['type' => 'industry']) }}" 
                               class="btn {{ (isset($type) && $type === 'industry') ? 'btn-primary' : 'btn-outline-primary' }}">
                                <i class="fa fa-industry"></i> Industry News
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($transformedArticles as $article)
            <div class="col-lg-4 col-md-6 mb30">
                <div class="bloglist item">
                    <div class="post-content">
                        <div class="post-image">
                            @if($article->featured_image_url)
                            <img alt="{{ $article->title }}" 
                                 src="{{ $article->featured_image_url }}" 
                                 class="lazy img-fluid"
                                 style="width: 100%; height: 250px; object-fit: cover;"
                                 onerror="this.src='{{ asset('images/news/default-news.jpg') }}'">
                            @else
                            <img alt="{{ $article->title }}" 
                                 src="{{ asset('images/news/default-news.jpg') }}" 
                                 class="lazy img-fluid"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                            @endif
                            <div class="date-box">
                                <div class="m">{{ date('d', strtotime($article->published_at)) }}</div>
                                <div class="d">{{ date('M', strtotime($article->published_at)) }}</div>
                            </div>
                        </div>
                        <div class="post-text">
                            @if(isset($article->external_source))
                            <span class="p-tagline">
                                <i class="fa fa-external-link"></i> {{ $article->external_source }}
                            </span>
                            @endif
                            <h4>
                                <a href="{{ $article->external_url ?? '#' }}" target="_blank">
                                    {{ Str::limit($article->title, 80) }}
                                </a>
                            </h4>
                            <p>{{ Str::limit($article->excerpt, 120) }}</p>
                            <a href="{{ $article->external_url ?? '#' }}" 
                               target="_blank" 
                               class="btn-main btn-sm">
                                Read Full Article <i class="fa fa-external-link"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fa fa-newspaper-o fa-4x text-muted mb-3"></i>
                    <h4>No external news available</h4>
                    <p>Unable to fetch news from external sources at the moment.</p>
                    <a href="{{ route('news.index') }}" class="btn btn-primary mt-3">
                        Browse Our News
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Info Banner -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Note:</strong> These articles are sourced from external news providers via News API. 
                    Click "Read Full Article" to view the complete story on the original source.
                    @auth
                        @if(auth()->user()->role === 'admin')
                        You can import these articles to your database using the "Import Articles" button above.
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.post-image {
    position: relative;
    overflow: hidden;
}

.post-image img {
    transition: transform 0.3s ease;
}

.bloglist:hover .post-image img {
    transform: scale(1.05);
}

.p-tagline {
    display: inline-block;
    padding: 4px 12px;
    background: #f0f0f0;
    border-radius: 3px;
    font-size: 12px;
    margin-bottom: 10px;
    color: #666;
}

.date-box {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    z-index: 2;
}

.date-box .m {
    font-size: 24px;
    font-weight: bold;
    line-height: 1;
}

.date-box .d {
    font-size: 12px;
    text-transform: uppercase;
}
</style>
@endpush

@endsection

