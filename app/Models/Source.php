<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'url',
        'extraction_rules',
        'is_active',
        'last_fetched_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'extraction_rules' => 'array',
            'metadata' => 'array',
            'is_active' => 'boolean',
            'last_fetched_at' => 'datetime',
        ];
    }

    public function rawArticles(): HasMany
    {
        return $this->hasMany(RawArticle::class);
    }
}
