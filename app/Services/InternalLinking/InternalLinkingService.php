<?php

namespace App\Services\InternalLinking;

use App\Models\AiArticle;
use App\Models\ArticleLink;

class InternalLinkingService
{
    public function build(AiArticle $article): void
    {
        $relatedArticles = AiArticle::query()
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(5)
            ->get();

        ArticleLink::query()->where('ai_article_id', $article->id)->delete();

        foreach ($relatedArticles as $related) {
            ArticleLink::create([
                'ai_article_id' => $article->id,
                'linked_ai_article_id' => $related->id,
                'anchor_text' => $related->title,
                'relationship_type' => 'related',
                'score' => 75,
            ]);
        }
    }
}
