<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RawArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'category_id',
        'title',
        'url',
        'canonical_url',
        'excerpt',
        'content_raw',
        'content_clean',
        'content_hash',
        'language',
        'status',
        'fetched_at',
        'cleaned_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'fetched_at' => 'datetime',
            'cleaned_at' => 'datetime',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function fact(): HasOne
    {
        return $this->hasOne(ArticleFact::class);
    }

    public function aiArticle(): HasOne
    {
        return $this->hasOne(AiArticle::class);
    }

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class);
    }
}
