<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleFact extends Model
{
    use HasFactory;

    protected $fillable = [
        'raw_article_id',
        'facts',
        'summary',
        'confidence',
        'model',
    ];

    protected function casts(): array
    {
        return [
            'facts' => 'array',
            'confidence' => 'decimal:2',
        ];
    }

    public function rawArticle(): BelongsTo
    {
        return $this->belongsTo(RawArticle::class);
    }
}
