<?php

namespace App\Repositories;

use App\Models\AiArticle;
use App\Models\RawArticle;

class ArticleRepository
{
    public function rawByUrl(string $url): ?RawArticle
    {
        return RawArticle::query()->where('url', $url)->first();
    }

    public function draftsForLinking(int $articleId)
    {
        return AiArticle::query()
            ->where('id', '!=', $articleId)
            ->where('status', 'published')
            ->latest('published_at');
    }
}
