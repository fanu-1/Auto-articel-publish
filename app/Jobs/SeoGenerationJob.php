<?php

namespace App\Jobs;

use App\Models\AiArticle;
use App\Services\SEO\SeoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SeoGenerationJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $aiArticleId)
    {
    }

    public function handle(SeoService $seo): void
    {
        $article = AiArticle::query()->findOrFail($this->aiArticleId);
        $seo->generate($article);

        InternalLinkingJob::dispatch($article->id);
    }
}
