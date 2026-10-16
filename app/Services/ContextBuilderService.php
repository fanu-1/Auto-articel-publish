<?php

namespace App\Services;

use App\DTOs\PipelineContextData;
use App\Models\AiArticle;
use App\Models\RawArticle;
use App\Models\Setting;

class ContextBuilderService
{
    public function build(RawArticle $rawArticle): PipelineContextData
    {
        $facts = $rawArticle->fact?->facts ?? [];
        $entities = $rawArticle->entities?->toArray() ?? [];
        $relatedArticles = AiArticle::query()
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(5)
            ->get(['id', 'title', 'slug'])
            ->toArray();
        $settings = Setting::query()->pluck('value', 'key')->all();

        return new PipelineContextData(
            rawArticleId: $rawArticle->id,
            aiArticleId: $rawArticle->aiArticle?->id,
            facts: $facts,
            entities: $entities,
            relatedArticles: $relatedArticles,
            settings: $settings + [
                'summary' => $rawArticle->fact?->summary,
                'confidence' => $rawArticle->fact?->confidence,
            ],
        );
    }
}
