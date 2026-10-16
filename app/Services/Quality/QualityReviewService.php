<?php

namespace App\Services\Quality;

use App\Models\AiArticle;
use App\Services\AI\OpenAIService;

class QualityReviewService
{
    public function __construct(
        private readonly OpenAIService $openAi,
    ) {
    }

    public function review(AiArticle $article): array
    {
        return $this->openAi->reviewQuality([
            'title' => $article->title,
            'summary' => $article->summary,
            'content' => $article->content,
            'word_count' => $article->word_count,
        ]);
    }
}
