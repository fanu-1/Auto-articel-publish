<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_article_id',
        'category_id',
        'title',
        'slug',
        'content',
        'summary',
        'context',
        'quality_report',
        'status',
        'word_count',
        'quality_score',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'quality_report' => 'array',
            'seo_keywords' => 'array',
            'published_at' => 'datetime',
            'quality_score' => 'decimal:2',
        ];
    }

    public function rawArticle(): BelongsTo
    {
        return $this->belongsTo(RawArticle::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ArticleFaq::class)->orderBy('sort_order');
    }

    public function links(): HasMany
    {
        return $this->hasMany(ArticleLink::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class);
    }
}
