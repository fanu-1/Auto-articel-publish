<?php

namespace App\Jobs;

use App\Models\AiArticle;
use App\Services\Quality\QualityReviewService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QualityCheckJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $aiArticleId)
    {
    }

    public function handle(QualityReviewService $reviewer): void
    {
        $article = AiArticle::query()->with(['rawArticle.fact'])->findOrFail($this->aiArticleId);
        $report = $reviewer->review($article);

        $article->quality_report = $report;
        $article->quality_score = $report['score'] ?? 0;
        $article->save();

        SeoGenerationJob::dispatch($article->id);
    }
}
