<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ScholarshipInsight extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'cover_image',
        'excerpt',
        'body',
        'source_url',
        'is_published',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
    ];

    // ─────────────────────────────────────
    // Categories
    // ─────────────────────────────────────

    public const CATEGORIES = [
        'article'     => 'Article',
        'tip'         => 'Tip & Strategy',
        'guide'       => 'Guide',
        'opportunity' => 'Scholarship Opportunity',
    ];

    // ─────────────────────────────────────
    // Auto-slug
    // ─────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function (self $model) {
            if ($model->isDirty('title') && ! $model->isDirty('slug')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    // ─────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->latest('published_at');
    }

    // ─────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
