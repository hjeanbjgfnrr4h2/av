<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'thumbnail',
        'videos_count', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_category')
            ->withTimestamps();
    }
}
