<?php

namespace App\Services\AI;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenAIService
{
    public function __construct(
        private readonly PromptService $prompts,
    ) {
    }

    public function extractFacts(string $content, array $context = []): array
    {
        return $this->json('fact-extraction', [
            'content' => $content,
            'context' => $context,
        ]);
    }

    public function generateArticle(array $context): array
    {
        return $this->json('article-generation', $context);
    }

    public function generateFaqs(array $context): array
    {
        return $this->json('faq-generation', $context);
    }

    public function generateSeo(array $context): array
    {
        return $this->json('seo-generation', $context);
    }

    public function reviewQuality(array $context): array
    {
        return $this->json('quality-review', $context);
    }

    public function humanize(string $content): string
    {
        $response = $this->json('humanization', ['content' => $content]);

        return (string) ($response['content'] ?? $content);
    }

    private function json(string $promptName, array $context): array
    {
        if (! config('services.openai.api_key')) {
            return $this->fallback($promptName, $context);
        }

        $prompt = $this->prompts->get($promptName, array_map(
            fn (mixed $value) => is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : (string) $value,
            $context
        ));

        try {
            $response = Http::baseUrl(rtrim(config('services.openai.base_url'), '/'))
                ->withToken(config('services.openai.api_key'))
                ->acceptJson()
                ->asJson()
                ->post('/chat/completions', [
                    'model' => config('services.openai.model'),
                    'temperature' => 0.35,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => 'You generate structured, helpful, knowledge-first publishing outputs.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ])
                ->throw()
                ->json();

            $content = data_get($response, 'choices.0.message.content', '{}');
            $decoded = json_decode($content, true);

            return is_array($decoded) ? $decoded : $this->fallback($promptName, $context);
        } catch (RequestException) {
            return $this->fallback($promptName, $context);
        }
    }

    private function fallback(string $promptName, array $context): array
    {
        return match ($promptName) {
            'fact-extraction' => [
                'facts' => $this->extractFallbackFacts((string) ($context['content'] ?? '')),
                'summary' => Str::limit(strip_tags((string) ($context['content'] ?? '')), 240),
                'confidence' => 72,
            ],
            'article-generation' => [
                'title' => (string) ($context['title'] ?? 'Knowledge Brief'),
                'summary' => $this->articleSummary($context),
                'content' => $this->articleBody($context),
                'faq' => [],
                'image_suggestions' => [],
            ],
            'faq-generation' => [
                'faqs' => [
                    [
                        'question' => 'What is the main takeaway?',
                        'answer' => 'The main takeaway is the practical knowledge extracted from the source material.',
                    ],
                ],
            ],
            'seo-generation' => [
                'seo_title' => Str::limit((string) ($context['title'] ?? 'Knowledge Article'), 60, ''),
                'seo_description' => Str::limit((string) ($context['summary'] ?? ''), 155, ''),
                'seo_keywords' => ['knowledge', 'analysis', 'insights'],
            ],
            'quality-review' => [
                'score' => 84,
                'approved' => true,
                'notes' => ['Fallback review used because OPENAI_API_KEY is missing.'],
            ],
            'humanization' => [
                'content' => (string) ($context['content'] ?? ''),
            ],
            default => [],
        };
    }

    private function extractFallbackFacts(string $content): array
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', trim(strip_tags($content))) ?: [];

        return collect($sentences)
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }

    private function articleSummary(array $context): string
    {
        $summary = (string) ($context['summary'] ?? '');

        if ($summary !== '') {
            return Str::limit($summary, 240);
        }

        return 'A knowledge-first article that distills raw reporting into a practical, original explanation.';
    }

    private function articleBody(array $context): string
    {
        $title = (string) ($context['title'] ?? 'Knowledge Brief');
        $facts = collect($context['facts'] ?? [])->filter()->take(5)->map(fn (string $fact) => "<li>{$fact}</li>")->implode('');
        $summary = $this->articleSummary($context);

        return <<<HTML
<h2>{$title}</h2>
<p>{$summary}</p>
<h3>What matters</h3>
<ul>{$facts}</ul>
<h3>Why it matters</h3>
<p>This draft connects the source material to broader context, practical implications, and reader value.</p>
HTML;
    }
}
