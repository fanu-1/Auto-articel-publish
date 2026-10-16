<?php

namespace App\Services;

use App\Models\AiArticle;
use App\Models\ArticleFaq;
use App\Models\RawArticle;
use App\Services\AI\OpenAIService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleGenerationService
{
    public function __construct(
        private readonly OpenAIService $openAi,
    ) {
    }

    public function generate(RawArticle $rawArticle, array $context): AiArticle
    {
        $payload = $this->openAi->generateArticle([
            'title' => $rawArticle->title,
            'summary' => $context['summary'] ?? '',
            'facts' => $context['facts'] ?? [],
            'entities' => $context['entities'] ?? [],
            'related_articles' => $context['related_articles'] ?? [],
            'word_target' => config('knowledge.default_word_target'),
            'tone' => config('knowledge.default_tone'),
        ]);
        $faqPayload = $this->openAi->generateFaqs([
            'title' => $rawArticle->title,
            'content' => $payload['content'] ?? $rawArticle->content_clean ?? $rawArticle->content_raw,
            'facts' => $context['facts'] ?? [],
        ]);

        $content = (string) Arr::get($payload, 'content', '');
        $title = (string) Arr::get($payload, 'title', $rawArticle->title);
        $summary = (string) Arr::get($payload, 'summary', $context['summary'] ?? '');

        $article = AiArticle::updateOrCreate(
            ['raw_article_id' => $rawArticle->id],
            [
                'category_id' => $rawArticle->category_id,
                'title' => $title,
                'slug' => Str::slug($title).'-'.$rawArticle->id,
                'content' => $content,
                'summary' => $summary,
                'context' => json_encode($context, JSON_PRETTY_PRINT),
                'status' => 'draft',
                'word_count' => str_word_count(strip_tags($content)),
            ]
        );

        $this->syncFaqs($article, $payload['faq'] ?? $faqPayload['faqs'] ?? []);

        return $article;
    }

    public function humanize(AiArticle $article): AiArticle
    {
        $article->content = $this->openAi->humanize($article->content);
        $article->word_count = str_word_count(strip_tags($article->content));
        $article->save();

        return $article;
    }

    private function syncFaqs(AiArticle $article, array $faqs): void
    {
        ArticleFaq::query()->where('ai_article_id', $article->id)->delete();

        foreach ($faqs as $index => $faq) {
            ArticleFaq::create([
                'ai_article_id' => $article->id,
                'question' => (string) ($faq['question'] ?? ''),
                'answer' => (string) ($faq['answer'] ?? ''),
                'sort_order' => $index,
            ]);
        }
    }
}
