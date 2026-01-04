<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Video extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title', 'slug', 'description', 'video_url', 'thumbnail', 'poster_image',
        'duration', 'views_count', 'favorites_count', 'rating',
        'is_censored', 'is_featured', 'channel_id', 'published_at'
    ];

    protected $casts = [
        'is_censored' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'rating' => 'decimal:2'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function actresses(): BelongsToMany
    {
        return $this->belongsToMany(Actress::class, 'video_actress');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'video_category');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'video_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(VideoView::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
