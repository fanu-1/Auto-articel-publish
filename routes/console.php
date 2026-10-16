<?php

use App\Jobs\FetchArticleJob;
use App\Models\Source;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('source:fetch {sourceId?}', function (?int $sourceId = null) {
    $sources = Source::query()->where('is_active', true);

    if ($sourceId !== null) {
        $sources->where('id', $sourceId);
    }

    $sources = $sources->get();

    if ($sources->isEmpty()) {
        $this->comment('No active sources found.');

        return;
    }

    foreach ($sources as $source) {
        FetchArticleJob::dispatch($source->id);
        $this->info("Queued source {$source->id}: {$source->url}");
    }
})->purpose('Dispatch fetch jobs for active sources');
