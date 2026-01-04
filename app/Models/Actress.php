<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Actress extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug', 'avatar', 'bio', 'birthdate', 'nationality',
        'height', 'measurements', 'views_count', 'videos_count', 'is_featured'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_featured' => 'boolean'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_actress');
    }
}
