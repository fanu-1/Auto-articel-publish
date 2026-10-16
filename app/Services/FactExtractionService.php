<?php

namespace App\Services;

use App\Models\ArticleFact;
use App\Models\RawArticle;
use App\Services\AI\OpenAIService;

class FactExtractionService
{
    public function __construct(
        private readonly OpenAIService $openAi,
    ) {
    }

    public function extract(RawArticle $rawArticle): ArticleFact
    {
        $payload = $this->openAi->extractFacts($rawArticle->content_clean ?? $rawArticle->content_raw, [
            'title' => $rawArticle->title,
            'source' => $rawArticle->source?->name,
            'url' => $rawArticle->url,
        ]);

        return ArticleFact::updateOrCreate(
            ['raw_article_id' => $rawArticle->id],
            [
                'facts' => $payload['facts'] ?? [],
                'summary' => $payload['summary'] ?? null,
                'confidence' => $payload['confidence'] ?? 0,
                'model' => config('services.openai.model'),
            ]
        );
    }
}
