<?php

namespace App\Jobs;

use App\Models\AiArticle;
use App\Models\RawArticle;
use App\Services\ArticleGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateArticleJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $rawArticleId)
    {
    }

    public function handle(ArticleGenerationService $generator): void
    {
        $rawArticle = RawArticle::query()->with('fact')->findOrFail($this->rawArticleId);
        $context = $rawArticle->metadata['pipeline_context'] ?? [];
        $article = $generator->generate($rawArticle, $context);

        QualityCheckJob::dispatch($article->id);
    }
}
