<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'images',
        'category',
        'tags',
        'author_id',
        'published_at',
        'status',
        'is_featured',
        'meta_title',
        'meta_description',
        'views_count',
        'likes_count',
        'comments_count',
        'reading_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'reading_time' => 'integer',
        'deleted_at' => 'datetime'
    ];

    /**
     * News categories enum values
     */
    const CATEGORIES = [
        'car_reviews' => 'Car Reviews',
        'travel_tips' => 'Travel Tips',
        'industry_news' => 'Industry News',
        'company_news' => 'Company News',
        'promotions' => 'Promotions',
        'guides' => 'Guides',
        'events' => 'Events'
    ];

    /**
     * Get the author of the news article
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        return asset('images/news/' . ($this->featured_image ?: 'default-news.jpg'));
    }

    /**
     * Get the gallery images URLs
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }

        return array_map(function ($image) {
            return asset('images/news/' . $image);
        }, $this->gallery);
    }

    /**
     * Get the formatted published date
     */
    public function getFormattedPublishedDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }

    /**
     * Get the article excerpt or generate from content
     */
    public function getExcerptAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        // Generate excerpt from content if not provided
        return substr(strip_tags($this->content), 0, 200) . '...';
    }

    /**
     * Get the reading time in minutes
     */
    public function getReadingTimeAttribute($value): int
    {
        if ($value) {
            return $value;
        }

        // Calculate reading time based on content (average 200 words per minute)
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200));
    }

    /**
     * Scope to get published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope to get featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to search articles
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%')
              ->orWhere('excerpt', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope to get recent articles
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
                    ->orderBy('published_at', 'desc')
                    ->limit($limit);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Generate slug from title
     */
    public static function generateSlug($title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
