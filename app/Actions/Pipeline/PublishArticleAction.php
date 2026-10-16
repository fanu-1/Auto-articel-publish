<?php

namespace App\Actions\Pipeline;

use App\Events\ArticlePublished;
use App\Models\AiArticle;

class PublishArticleAction
{
    public function execute(AiArticle $article): AiArticle
    {
        $article->status = 'published';
        $article->published_at = now();
        $article->save();

        ArticlePublished::dispatch($article);

        return $article;
    }
}
