<?php

namespace App\Jobs;

use App\Actions\Pipeline\PublishArticleAction;
use App\Models\AiArticle;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishArticleJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $aiArticleId,
        public bool $publishNow = false,
    ) {
    }

    public function handle(PublishArticleAction $action): void
    {
        $article = AiArticle::query()->findOrFail($this->aiArticleId);

        if ($this->publishNow || config('knowledge.auto_publish')) {
            $action->execute($article);
            return;
        }

        $article->status = 'draft';
        $article->save();
    }
}
