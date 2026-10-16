<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'ai_article_id',
        'linked_ai_article_id',
        'anchor_text',
        'relationship_type',
        'score',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'score' => 'decimal:2',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(AiArticle::class, 'ai_article_id');
    }

    public function linkedArticle(): BelongsTo
    {
        return $this->belongsTo(AiArticle::class, 'linked_ai_article_id');
    }
}
