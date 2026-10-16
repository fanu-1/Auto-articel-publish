<?php

namespace App\Jobs;

use App\Models\RawArticle;
use App\Services\ContentCleaner;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanContentJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $rawArticleId)
    {
    }

    public function handle(ContentCleaner $cleaner): void
    {
        $rawArticle = RawArticle::query()->findOrFail($this->rawArticleId);
        $rawArticle->content_clean = $cleaner->clean($rawArticle->content_raw);
        $rawArticle->status = 'cleaned';
        $rawArticle->cleaned_at = now();
        $rawArticle->save();

        ExtractFactsJob::dispatch($rawArticle->id);
    }
}
