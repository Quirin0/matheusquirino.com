<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'full_description',
        'image_url',
        'live_url',
        'github_url',
        'tags',
        'featured',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'featured' => 'boolean',
        'order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
