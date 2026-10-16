<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use Illuminate\Support\Facades\Log;

class LogArticlePublished
{
    public function handle(ArticlePublished $event): void
    {
        Log::info('Article published', [
            'article_id' => $event->article->id,
            'title' => $event->article->title,
        ]);
    }
}
