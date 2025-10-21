<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }
    /**
     * Display a listing of published news articles.
     */
    public function index(Request $request)
    {
        // Get page number (default to 1)
        $page = $request->get('page', 1);
        
        // Fetch news from API for featured section (6 articles per page)
        $pageSize = 6;
        $type = $request->get('type', 'general'); // general, ev, reviews, industry
        
        // Fetch based on type with page parameter
        switch ($type) {
            case 'ev':
                $apiResponse = $this->newsApiService->fetchElectricVehicleNews($pageSize, $page);
                break;
            case 'reviews':
                $apiResponse = $this->newsApiService->fetchCarReviews($pageSize, $page);
                break;
            case 'industry':
                $apiResponse = $this->newsApiService->fetchIndustryNews($pageSize, $page);
                break;
            default:
                $apiResponse = $this->newsApiService->fetchCarNews($pageSize, $page);
        }
        
        $articles = collect($apiResponse['articles'] ?? []);
        
        // Transform articles for display
        $transformedArticles = $articles->map(function($article) {
            return (object) $this->newsApiService->transformArticle($article);
        });
        
        // All articles are featured for the main page
        $featuredNews = $transformedArticles;
        
        $categories = News::CATEGORIES;

        return view('news.index', compact('featuredNews', 'categories', 'apiResponse', 'type', 'page'));
    }

    /**
     * Display news articles in grid format with sidebar
     */
    public function gridRightSidebar(Request $request)
    {
        return $this->gridView($request, 'right');
    }

    public function gridLeftSidebar(Request $request)
    {
        return $this->gridView($request, 'left');
    }

    public function gridNoSidebar(Request $request)
    {
        return $this->gridView($request, 'none');
    }

    /**
     * Display news articles in standard format with sidebar
     */
    public function standardRightSidebar(Request $request)
    {
        return $this->standardView($request, 'right');
    }

    public function standardLeftSidebar(Request $request)
    {
        return $this->standardView($request, 'left');
    }

    public function standardNoSidebar(Request $request)
    {
        return $this->standardView($request, 'none');
    }

    /**
     * Show news by category.
     */
    public function category($category)
    {
        $categories = $this->getCategories();
        
        if (!array_key_exists($category, $categories)) {
            abort(404, 'Category not found');
        }
        
        $news = News::where('category', $category)
                   ->where('status', 'published')
                   ->orderBy('published_at', 'desc')
                   ->paginate(12);

        return view('news.category', compact('news', 'category', 'categories'));
    }

    /**
     * Search news articles
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('q', '');
        $category = $request->get('category');
        $categories = $this->getCategories();

        $query = News::published()->with('author');

        if ($searchTerm) {
            $query->search($searchTerm);
        }

        if ($category && array_key_exists($category, $categories)) {
            $query->category($category);
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12);

        return view('news.search', compact('news', 'searchTerm', 'category', 'categories'));
    }

    /**
     * Display the specified news article.
     */
    public function show($slug)
    {
        $article = News::where('slug', $slug)
                      ->published()
                      ->with('author')
                      ->firstOrFail();

        // Increment views
        $article->incrementViews();

        // Get related articles
        $relatedArticles = News::published()
                              ->where('id', '!=', $article->id)
                              ->where('category', $article->category)
                              ->limit(3)
                              ->get();

        // Get recent articles for sidebar
        $recentArticles = News::published()
                             ->where('id', '!=', $article->id)
                             ->recent(5)
                             ->get();

        return view('news.show', compact('article', 'relatedArticles', 'recentArticles'));
    }

    /**
     * Show the form for creating a new article (Admin only).
     */
    public function create()
    {
        $this->authorize('create', News::class);
        $categories = News::CATEGORIES;
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created article (Admin only).
     */
    public function store(Request $request)
    {
        $this->authorize('create', News::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|in:' . implode(',', array_keys(News::CATEGORIES)),
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug
        $validated['slug'] = News::generateSlug($validated['title']);
        $validated['author_id'] = Auth::id();
        
        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'draft';
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $validated['featured_image'] = basename($imagePath);
        }

        // Set published_at if publishing now
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article = News::create($validated);

        return redirect()->route('news.show', $article->slug)
                        ->with('success', 'Article created successfully!');
    }

    /**
     * Show the form for editing the specified article (Admin only).
     */
    public function edit($id)
    {
        $article = News::findOrFail($id);
        $this->authorize('update', $article);
        $categories = News::CATEGORIES;
        return view('news.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article (Admin only).
     */
    public function update(Request $request, $id)
    {
        $article = News::findOrFail($id);
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|in:' . implode(',', array_keys(News::CATEGORIES)),
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Update slug if title changed
        if ($validated['title'] !== $article->title) {
            $validated['slug'] = News::generateSlug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete('news/' . $article->featured_image);
            }
            
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $validated['featured_image'] = basename($imagePath);
        }

        // Set published_at if publishing now
        if (isset($validated['status']) && $validated['status'] === 'published' && !$article->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('news.show', $article->slug)
                        ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified article (Admin only).
     */
    public function destroy($id)
    {
        $article = News::findOrFail($id);
        $this->authorize('delete', $article);

        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete('news/' . $article->featured_image);
        }

        $article->delete();

        return redirect()->route('news.index')
                        ->with('success', 'Article deleted successfully!');
    }

    /**
     * Helper method for grid views
     */
    private function gridView(Request $request, $sidebar)
    {
        $query = News::published()->with('author');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Handle monthly archives
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereRaw("strftime('%Y', published_at) = ?", [$request->year])
                  ->whereRaw("strftime('%m', published_at) = ?", [sprintf('%02d', $request->month)]);
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12);
        
        // Get data for sidebar widgets
        $recentNews = News::published()->recent(5)->get();
        
        // Get category counts for widget
        $categoryCounts = [];
        foreach (News::CATEGORIES as $key => $name) {
            $categoryCounts[$key] = News::published()->category($key)->count();
        }
        
        // Get archives data (last 12 months) - SQLite compatible
        $archives = collect([]);
        
        try {
            $publishedNews = News::published()
                                ->select('published_at')
                                ->orderBy('published_at', 'desc')
                                ->get();
            
            $monthlyData = [];
            foreach ($publishedNews as $article) {
                if (!$article->published_at) continue;
                
                $year = $article->published_at->format('Y');
                $month = $article->published_at->format('n');
                $monthName = $article->published_at->format('F');
                $key = $year . '-' . sprintf('%02d', $month);
                
                if (!isset($monthlyData[$key])) {
                    $monthlyData[$key] = (object) [
                        'year' => $year,
                        'month' => sprintf('%02d', $month),
                        'month_name' => $monthName,
                        'count' => 0
                    ];
                }
                $monthlyData[$key]->count++;
            }
            
            // Sort by year and month desc, limit to 12
            krsort($monthlyData);
            $archives = collect(array_slice($monthlyData, 0, 12))->values();
        } catch (\Exception $e) {
            // If there's any error, just return empty archives
            $archives = collect([]);
        }

        $viewName = $sidebar === 'none' ? 'news.grid-no-sidebar' : "news.grid-{$sidebar}-sidebar";
        
        return view($viewName, compact('news', 'recentNews', 'categoryCounts', 'archives'));
    }

    /**
     * Helper method for standard views
     */
    private function standardView(Request $request, $sidebar)
    {
        $query = News::published()->with('author');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Handle monthly archives
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereRaw("strftime('%Y', published_at) = ?", [$request->year])
                  ->whereRaw("strftime('%m', published_at) = ?", [sprintf('%02d', $request->month)]);
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(6);
        
        // Get data for sidebar widgets
        $recentNews = News::published()->recent(5)->get();
        $featuredNews = News::published()->featured()->limit(3)->get();
        
        // Get category counts for widget
        $categoryCounts = [];
        foreach (News::CATEGORIES as $key => $name) {
            $categoryCounts[$key] = News::published()->category($key)->count();
        }
        
        // Get archives data (last 12 months) - SQLite compatible  
        $archives = collect([]);
        
        try {
            $publishedNews = News::published()
                                ->select('published_at')
                                ->orderBy('published_at', 'desc')
                                ->get();
            
            $monthlyData = [];
            foreach ($publishedNews as $article) {
                if (!$article->published_at) continue;
                
                $year = $article->published_at->format('Y');
                $month = $article->published_at->format('n');
                $monthName = $article->published_at->format('F');
                $key = $year . '-' . sprintf('%02d', $month);
                
                if (!isset($monthlyData[$key])) {
                    $monthlyData[$key] = (object) [
                        'year' => $year,
                        'month' => sprintf('%02d', $month),
                        'month_name' => $monthName,  
                        'count' => 0
                    ];
                }
                $monthlyData[$key]->count++;
            }
            
            // Sort by year and month desc, limit to 12
            krsort($monthlyData);
            $archives = collect(array_slice($monthlyData, 0, 12))->values();
        } catch (\Exception $e) {
            // If there's any error, just return empty archives
            $archives = collect([]);
        }

        $viewName = $sidebar === 'none' ? 'news.standard-no-sidebar' : "news.standard-{$sidebar}-sidebar";
        
        return view($viewName, compact('news', 'recentNews', 'featuredNews', 'categoryCounts', 'archives'));
    }

    /**
     * Get categories for display
     */
    private function getCategories()
    {
        return [
            'car_reviews' => 'Car Reviews',
            'travel_tips' => 'Travel Tips',
            'industry_news' => 'Industry News',
            'company_news' => 'Company News',
            'promotions' => 'Promotions',
            'guides' => 'Guides',
            'events' => 'Events'
        ];
    }

    /**
     * Fetch and display external car news from News API
     */
    public function externalNews(Request $request)
    {
        $pageSize = $request->get('pageSize', 20);
        $type = $request->get('type', 'general'); // general, ev, reviews, industry
        
        // Fetch based on type
        switch ($type) {
            case 'ev':
                $apiResponse = $this->newsApiService->fetchElectricVehicleNews($pageSize);
                break;
            case 'reviews':
                $apiResponse = $this->newsApiService->fetchCarReviews($pageSize);
                break;
            case 'industry':
                $apiResponse = $this->newsApiService->fetchIndustryNews($pageSize);
                break;
            default:
                $apiResponse = $this->newsApiService->fetchCarNews($pageSize);
        }
        
        $articles = collect($apiResponse['articles'] ?? []);
        
        // Transform articles for display
        $transformedArticles = $articles->map(function($article) {
            return (object) $this->newsApiService->transformArticle($article);
        });
        
        $categories = $this->getCategories();
        
        return view('news.external', compact('transformedArticles', 'categories', 'apiResponse', 'type'));
    }

    /**
     * Display specific external news article
     */
    public function showExternal(Request $request)
    {
        $url = $request->get('url');
        
        if (!$url) {
            abort(404);
        }
        
        // Redirect to the external article
        return redirect()->away($url);
    }

    /**
     * Import articles from News API to database
     */
    public function importFromApi(Request $request)
    {
        $this->authorize('create', News::class);
        
        $pageSize = $request->get('count', 10);
        $category = $request->get('category', 'industry_news');
        
        $apiResponse = $this->newsApiService->fetchCarNews($pageSize);
        $articles = $apiResponse['articles'] ?? [];
        
        $imported = 0;
        $skipped = 0;
        
        foreach ($articles as $article) {
            // Check if article already exists by title
            $exists = News::where('title', $article['title'])->exists();
            
            if ($exists) {
                $skipped++;
                continue;
            }
            
            try {
                $transformed = $this->newsApiService->transformArticle($article, $category);
                
                // Download and save featured image if available
                if (isset($transformed['featured_image_url'])) {
                    try {
                        $imageContent = file_get_contents($transformed['featured_image_url']);
                        $imageName = 'news_' . time() . '_' . $imported . '.jpg';
                        Storage::disk('public')->put('news/' . $imageName, $imageContent);
                        $transformed['featured_image'] = $imageName;
                    } catch (\Exception $e) {
                        // If image download fails, continue without image
                    }
                    unset($transformed['featured_image_url']);
                }
                
                unset($transformed['external_source']);
                unset($transformed['external_url']);
                
                News::create($transformed);
                $imported++;
            } catch (\Exception $e) {
                Log::error('Failed to import article: ' . $e->getMessage());
                $skipped++;
            }
        }
        
        return redirect()->route('news.index')
                        ->with('success', "Imported {$imported} articles. Skipped {$skipped} duplicates.");
    }
}
