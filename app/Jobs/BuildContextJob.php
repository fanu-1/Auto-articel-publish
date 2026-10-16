<?php

namespace App\Jobs;

use App\Models\RawArticle;
use App\Services\ContextBuilderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BuildContextJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $rawArticleId)
    {
    }

    public function handle(ContextBuilderService $builder): void
    {
        $rawArticle = RawArticle::query()->with(['fact', 'entities', 'aiArticle'])->findOrFail($this->rawArticleId);
        $context = $builder->build($rawArticle);

        $metadata = $rawArticle->metadata ?? [];
        $metadata['pipeline_context'] = [
            'facts' => $context->facts,
            'entities' => $context->entities,
            'related_articles' => $context->relatedArticles,
            'settings' => $context->settings,
        ];
        $rawArticle->metadata = $metadata;
        $rawArticle->save();

        GenerateArticleJob::dispatch($rawArticle->id);
    }
}
