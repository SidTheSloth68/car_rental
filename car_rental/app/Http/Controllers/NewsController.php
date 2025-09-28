<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'category', 'search']);
    }

    /**
     * Display a listing of published news articles.
     */
    public function index(Request $request)
    {
        $query = News::published()->with('author');

        // Handle search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Handle category filter
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Handle sorting
        $sortBy = $request->get('sort', 'published_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['published_at', 'views_count', 'likes_count', 'title'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $news = $query->paginate(12);
        $featuredNews = News::published()->featured()->limit(3)->get();
        $categories = News::CATEGORIES;

        return view('news.index', compact('news', 'featuredNews', 'categories'));
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
     * Display news by category
     */
    public function category($category, Request $request)
    {
        if (!array_key_exists($category, News::CATEGORIES)) {
            abort(404);
        }

        $query = News::published()->category($category)->with('author');
        
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12);
        $categoryName = News::CATEGORIES[$category];
        $featuredNews = News::published()->featured()->where('category', $category)->limit(3)->get();

        return view('news.category', compact('news', 'category', 'categoryName', 'featuredNews'));
    }

    /**
     * Search news articles
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('q', '');
        $category = $request->get('category');

        $query = News::published()->with('author');

        if ($searchTerm) {
            $query->search($searchTerm);
        }

        if ($category && array_key_exists($category, News::CATEGORIES)) {
            $query->category($category);
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = News::CATEGORIES;

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
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug
        $validated['slug'] = News::generateSlug($validated['title']);
        $validated['author_id'] = Auth::id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $validated['featured_image'] = basename($imagePath);
        }

        // Set published_at if publishing now
        if ($validated['is_published'] && !$validated['published_at']) {
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
            'is_published' => 'boolean',
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
        if ($validated['is_published'] && !$article->published_at && !$validated['published_at']) {
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

        $news = $query->orderBy('published_at', 'desc')->paginate(9);
        $featuredNews = News::published()->featured()->limit(3)->get();
        $categories = News::CATEGORIES;
        $recentArticles = News::published()->recent(5)->get();

        return view("news.grid-{$sidebar}-sidebar", compact('news', 'featuredNews', 'categories', 'recentArticles', 'sidebar'));
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

        $news = $query->orderBy('published_at', 'desc')->paginate(6);
        $featuredNews = News::published()->featured()->limit(3)->get();
        $categories = News::CATEGORIES;
        $recentArticles = News::published()->recent(5)->get();

        return view("news.standard-{$sidebar}-sidebar", compact('news', 'featuredNews', 'categories', 'recentArticles', 'sidebar'));
    }
}
