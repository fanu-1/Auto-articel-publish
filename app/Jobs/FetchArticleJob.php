<?php

namespace App\Jobs;

use App\Models\RawArticle;
use App\Models\Source;
use App\Repositories\SourceRepository;
use App\Services\Scrapers\RssFeedScraper;
use App\Services\Scrapers\WebPageScraper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class FetchArticleJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $sourceId,
        public ?string $url = null,
    ) {
    }

    public function handle(RssFeedScraper $rssScraper, WebPageScraper $webPageScraper, SourceRepository $sources): void
    {
        $source = Source::query()->findOrFail($this->sourceId);
        $payload = [];

        if ($source->type === 'rss') {
            $items = $rssScraper->fetch($source->url);

            foreach ($items as $item) {
                $url = (string) ($item['url'] ?? $source->url);

                if (! $url) {
                    continue;
                }

                $rawArticle = RawArticle::updateOrCreate(
                    ['url' => $url],
                    [
                        'source_id' => $source->id,
                        'title' => (string) ($item['title'] ?? $source->name),
                        'canonical_url' => $url,
                        'excerpt' => (string) ($item['excerpt'] ?? null),
                        'content_raw' => (string) ($item['content'] ?? ''),
                        'content_hash' => hash('sha256', $url.'|'.($item['content'] ?? '')),
                        'language' => 'en',
                        'status' => 'fetched',
                        'fetched_at' => now(),
                    ]
                );

                CleanContentJob::dispatch($rawArticle->id);
            }

            $sources->markFetched($source);

            return;
        }

        $fetched = $webPageScraper->fetch($this->url ?: $source->url);
        $payload = [
            'title' => $source->name,
            'url' => $this->url ?: $source->url,
            'excerpt' => Str::limit($fetched['text'], 240),
            'content' => $fetched['html'],
        ];

        $url = (string) ($payload['url'] ?? $source->url);
        $rawArticle = RawArticle::updateOrCreate(
            ['url' => $url],
            [
                'source_id' => $source->id,
                'title' => (string) ($payload['title'] ?? $source->name),
                'canonical_url' => $url,
                'excerpt' => (string) ($payload['excerpt'] ?? null),
                'content_raw' => (string) ($payload['content'] ?? ''),
                'content_hash' => hash('sha256', $url.'|'.($payload['content'] ?? '')),
                'language' => 'en',
                'status' => 'fetched',
                'fetched_at' => now(),
            ]
        );

        $sources->markFetched($source);

        CleanContentJob::dispatch($rawArticle->id);
    }
}
