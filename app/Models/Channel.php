<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Channel extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'logo', 'banner',
        'videos_count', 'subscribers_count', 'is_verified'
    ];

    protected $casts = [
        'is_verified' => 'boolean'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
