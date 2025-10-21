<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NewsApiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY');
        // Check if it's mediastack API (api_live_ prefix) or NewsAPI.org
        if (str_starts_with($this->apiKey, 'api_live_')) {
            $this->baseUrl = 'http://api.mediastack.com/v1';
        } else {
            $this->baseUrl = env('NEWS_API_BASE_URL', 'https://newsapi.org/v2');
        }
    }

    /**
     * Fetch automotive and car-related news
     *
     * @param int $pageSize Number of articles to fetch (max 100)
     * @param int $page Page number
     * @param string $language Language code (default: 'en')
     * @return array
     */
    public function fetchCarNews($pageSize = 20, $page = 1, $language = 'en')
    {
        $cacheKey = "car_news_{$pageSize}_{$page}_{$language}";
        
        // Cache for 30 minutes to avoid excessive API calls
        return Cache::remember($cacheKey, 1800, function () use ($pageSize, $page, $language) {
            try {
                // Check if using mediastack API
                if (str_starts_with($this->apiKey, 'api_live_')) {
                    return $this->fetchMediastackNews($pageSize, $page, $language);
                }
                
                // Original NewsAPI.org implementation - focused on automotive/car news
                $response = Http::get("{$this->baseUrl}/everything", [
                    'apiKey' => $this->apiKey,
                    'q' => '(car OR automobile OR automotive OR "electric vehicle" OR EV OR SUV OR sedan OR "car rental" OR "car industry" OR Tesla OR BMW OR Mercedes OR Toyota OR Ford) AND NOT (accident OR crash OR death OR killed)',
                    'language' => $language,
                    'sortBy' => 'publishedAt',
                    'pageSize' => min($pageSize, 100),
                    'page' => $page,
                    'domains' => 'motortrend.com,caranddriver.com,autoweek.com,autoblog.com,topgear.com,roadandtrack.com,jalopnik.com,carbuzz.com,carscoops.com,insideevs.com,electrek.co',
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error('News API Error: ' . $response->status() . ' - ' . $response->body());
                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('News API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Fetch news from Mediastack API
     *
     * @param int $limit Number of articles
     * @param string $language Language code
     * @return array
     */
    private function fetchMediastackNews($limit = 20, $language = 'en')
    {
        try {
            $response = Http::get("{$this->baseUrl}/news", [
                'access_key' => $this->apiKey,
                'keywords' => 'car,automobile,vehicle,automotive,electric vehicle',
                'languages' => $language,
                'sort' => 'published_desc',
                'limit' => min($limit, 100),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Transform mediastack format to NewsAPI.org format for consistency
                return [
                    'status' => 'ok',
                    'totalResults' => $data['pagination']['total'] ?? 0,
                    'articles' => array_map(function($article) {
                        return [
                            'source' => ['name' => $article['source'] ?? 'Unknown'],
                            'author' => $article['author'] ?? null,
                            'title' => $article['title'] ?? 'Untitled',
                            'description' => $article['description'] ?? '',
                            'url' => $article['url'] ?? '',
                            'urlToImage' => $article['image'] ?? null,
                            'publishedAt' => $article['published_at'] ?? now()->toIso8601String(),
                            'content' => $article['description'] ?? '',
                        ];
                    }, $data['data'] ?? [])
                ];
            }

            Log::error('Mediastack API Error: ' . $response->status() . ' - ' . $response->body());
            return ['status' => 'error', 'articles' => []];
        } catch (\Exception $e) {
            Log::error('Mediastack API Exception: ' . $e->getMessage());
            return ['status' => 'error', 'articles' => []];
        }
    }

    /**
     * Fetch top headlines about cars
     *
     * @param string $country Country code (default: 'us')
     * @param int $pageSize Number of articles to fetch
     * @return array
     */
    public function fetchTopCarHeadlines($country = 'us', $pageSize = 10)
    {
        $cacheKey = "top_car_headlines_{$country}_{$pageSize}";
        
        return Cache::remember($cacheKey, 1800, function () use ($country, $pageSize) {
            try {
                // Check if using mediastack API
                if (str_starts_with($this->apiKey, 'api_live_')) {
                    $response = Http::get("{$this->baseUrl}/news", [
                        'access_key' => $this->apiKey,
                        'keywords' => 'car,automobile',
                        'countries' => $country,
                        'sort' => 'published_desc',
                        'limit' => min($pageSize, 100),
                    ]);
                } else {
                    $response = Http::get("{$this->baseUrl}/top-headlines", [
                        'apiKey' => $this->apiKey,
                        'q' => 'car OR automobile',
                        'country' => $country,
                        'pageSize' => min($pageSize, 100),
                    ]);
                }

                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Normalize mediastack response
                    if (str_starts_with($this->apiKey, 'api_live_') && isset($data['data'])) {
                        return [
                            'status' => 'ok',
                            'totalResults' => $data['pagination']['total'] ?? 0,
                            'articles' => array_map(function($article) {
                                return [
                                    'source' => ['name' => $article['source'] ?? 'Unknown'],
                                    'author' => $article['author'] ?? null,
                                    'title' => $article['title'] ?? 'Untitled',
                                    'description' => $article['description'] ?? '',
                                    'url' => $article['url'] ?? '',
                                    'urlToImage' => $article['image'] ?? null,
                                    'publishedAt' => $article['published_at'] ?? now()->toIso8601String(),
                                    'content' => $article['description'] ?? '',
                                ];
                            }, $data['data'])
                        ];
                    }
                    
                    return $data;
                }

                Log::error('News API Error: ' . $response->status() . ' - ' . $response->body());
                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('News API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Fetch news by specific topic
     *
     * @param string $topic Topic to search for
     * @param int $pageSize Number of articles
     * @return array
     */
    public function fetchNewsByTopic($topic, $pageSize = 10)
    {
        $cacheKey = "news_topic_" . md5($topic) . "_{$pageSize}";
        
        return Cache::remember($cacheKey, 1800, function () use ($topic, $pageSize) {
            try {
                // Check if using mediastack API
                if (str_starts_with($this->apiKey, 'api_live_')) {
                    $response = Http::get("{$this->baseUrl}/news", [
                        'access_key' => $this->apiKey,
                        'keywords' => $topic,
                        'languages' => 'en',
                        'sort' => 'published_desc',
                        'limit' => min($pageSize, 100),
                    ]);
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        return [
                            'status' => 'ok',
                            'totalResults' => $data['pagination']['total'] ?? 0,
                            'articles' => array_map(function($article) {
                                return [
                                    'source' => ['name' => $article['source'] ?? 'Unknown'],
                                    'author' => $article['author'] ?? null,
                                    'title' => $article['title'] ?? 'Untitled',
                                    'description' => $article['description'] ?? '',
                                    'url' => $article['url'] ?? '',
                                    'urlToImage' => $article['image'] ?? null,
                                    'publishedAt' => $article['published_at'] ?? now()->toIso8601String(),
                                    'content' => $article['description'] ?? '',
                                ];
                            }, $data['data'] ?? [])
                        ];
                    }
                } else {
                    $response = Http::get("{$this->baseUrl}/everything", [
                        'apiKey' => $this->apiKey,
                        'q' => $topic,
                        'language' => 'en',
                        'sortBy' => 'publishedAt',
                        'pageSize' => min($pageSize, 100),
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }
                }

                Log::error('News API Error: ' . $response->status() . ' - ' . $response->body());
                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('News API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Clear cached news data
     */
    public function clearCache()
    {
        Cache::forget('car_news_20_en');
        Cache::forget('top_car_headlines_us_10');
    }

    /**
     * Fetch electric vehicle news specifically
     *
     * @param int $pageSize Number of articles
     * @return array
     */
    public function fetchElectricVehicleNews($pageSize = 10, $page = 1)
    {
        $cacheKey = "ev_news_{$pageSize}_{$page}";
        
        return Cache::remember($cacheKey, 1800, function () use ($pageSize, $page) {
            try {
                $response = Http::get("{$this->baseUrl}/everything", [
                    'apiKey' => $this->apiKey,
                    'q' => '"electric vehicle" OR "EV" OR Tesla OR "electric car" OR "battery technology" OR charging',
                    'language' => 'en',
                    'sortBy' => 'publishedAt',
                    'pageSize' => min($pageSize, 100),
                    'page' => $page,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('EV News API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Fetch car reviews and comparisons
     *
     * @param int $pageSize Number of articles
     * @param int $page Page number
     * @return array
     */
    public function fetchCarReviews($pageSize = 10, $page = 1)
    {
        $cacheKey = "car_reviews_{$pageSize}_{$page}";
        
        return Cache::remember($cacheKey, 1800, function () use ($pageSize, $page) {
            try {
                $response = Http::get("{$this->baseUrl}/everything", [
                    'apiKey' => $this->apiKey,
                    'q' => '"car review" OR "road test" OR "comparison test" OR "first drive" OR "test drive"',
                    'language' => 'en',
                    'sortBy' => 'publishedAt',
                    'pageSize' => min($pageSize, 100),
                    'page' => $page,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('Car Reviews API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Fetch automotive industry news
     *
     * @param int $pageSize Number of articles
     * @param int $page Page number
     * @return array
     */
    public function fetchIndustryNews($pageSize = 10, $page = 1)
    {
        $cacheKey = "industry_news_{$pageSize}_{$page}";
        
        return Cache::remember($cacheKey, 1800, function () use ($pageSize, $page) {
            try {
                $response = Http::get("{$this->baseUrl}/everything", [
                    'apiKey' => $this->apiKey,
                    'q' => '"automotive industry" OR "car manufacturer" OR "auto sales" OR "car market" OR "new model"',
                    'language' => 'en',
                    'sortBy' => 'publishedAt',
                    'pageSize' => min($pageSize, 100),
                    'page' => $page,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return ['status' => 'error', 'articles' => []];
            } catch (\Exception $e) {
                Log::error('Industry News API Exception: ' . $e->getMessage());
                return ['status' => 'error', 'articles' => []];
            }
        });
    }

    /**
     * Transform API article to database-compatible format
     *
     * @param array $article
     * @param string $category
     * @return array
     */
    public function transformArticle($article, $category = 'industry_news')
    {
        return [
            'title' => $article['title'] ?? 'Untitled',
            'slug' => \Illuminate\Support\Str::slug($article['title'] ?? 'untitled-' . time()),
            'excerpt' => $article['description'] ?? '',
            'content' => $this->generateContent($article),
            'category' => $category,
            'author_id' => 1, // Default admin user
            'published_at' => isset($article['publishedAt']) ? date('Y-m-d H:i:s', strtotime($article['publishedAt'])) : now(),
            'is_published' => true,
            'is_featured' => false,
            'views_count' => 0,
            'likes_count' => 0,
            'meta_description' => \Illuminate\Support\Str::limit($article['description'] ?? '', 160),
            'external_source' => $article['source']['name'] ?? 'News API',
            'external_url' => $article['url'] ?? null,
            'featured_image_url' => $article['urlToImage'] ?? null,
        ];
    }

    /**
     * Generate HTML content from API article
     *
     * @param array $article
     * @return string
     */
    private function generateContent($article)
    {
        $content = '<div class="article-content">';
        
        if (isset($article['urlToImage'])) {
            $content .= '<img src="' . htmlspecialchars($article['urlToImage']) . '" alt="' . htmlspecialchars($article['title'] ?? '') . '" class="img-fluid mb-4">';
        }
        
        if (isset($article['description'])) {
            $content .= '<p class="lead">' . htmlspecialchars($article['description']) . '</p>';
        }
        
        if (isset($article['content'])) {
            $content .= '<p>' . nl2br(htmlspecialchars($article['content'])) . '</p>';
        }
        
        if (isset($article['url'])) {
            $content .= '<p><a href="' . htmlspecialchars($article['url']) . '" target="_blank" class="btn btn-primary">Read Full Article</a></p>';
        }
        
        if (isset($article['source']['name'])) {
            $content .= '<p class="text-muted"><small>Source: ' . htmlspecialchars($article['source']['name']) . '</small></p>';
        }
        
        $content .= '</div>';
        
        return $content;
    }
}
