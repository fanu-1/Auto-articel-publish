<?php

namespace App\Jobs;

use App\Models\RawArticle;
use App\Services\FactExtractionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExtractFactsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $rawArticleId)
    {
    }

    public function handle(FactExtractionService $facts): void
    {
        $rawArticle = RawArticle::query()->with(['source', 'fact', 'entities'])->findOrFail($this->rawArticleId);
        $facts->extract($rawArticle);

        BuildContextJob::dispatch($rawArticle->id);
    }
}
