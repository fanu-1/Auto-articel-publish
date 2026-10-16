<?php

namespace App\Actions\Pipeline;

use App\Jobs\FetchArticleJob;
use App\Models\Source;

class StartArticlePipelineAction
{
    public function execute(Source $source): void
    {
        FetchArticleJob::dispatch($source->id);
    }
}
