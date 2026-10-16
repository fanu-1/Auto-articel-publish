<?php

namespace App\Jobs;

use App\Models\AiArticle;
use App\Services\InternalLinking\InternalLinkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InternalLinkingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $aiArticleId)
    {
    }

    public function handle(InternalLinkingService $linking): void
    {
        $article = AiArticle::query()->findOrFail($this->aiArticleId);
        $linking->build($article);

        PublishArticleJob::dispatch($article->id, (bool) config('knowledge.auto_publish'));
    }
}
