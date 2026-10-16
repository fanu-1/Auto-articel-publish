<?php

namespace App\Services\SEO;

use App\Models\AiArticle;
use App\Services\AI\OpenAIService;
use Illuminate\Support\Arr;

class SeoService
{
    public function __construct(
        private readonly OpenAIService $openAi,
    ) {
    }

    public function generate(AiArticle $article): AiArticle
    {
        $payload = $this->openAi->generateSeo([
            'title' => $article->title,
            'summary' => $article->summary,
            'content' => $article->content,
        ]);

        $article->seo_title = Arr::get($payload, 'seo_title');
        $article->seo_description = Arr::get($payload, 'seo_description');
        $article->seo_keywords = Arr::get($payload, 'seo_keywords', []);
        $article->save();

        return $article;
    }
}
