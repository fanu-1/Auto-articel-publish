<?php

namespace App\Repositories;

use App\Models\Source;

class SourceRepository
{
    public function active()
    {
        return Source::query()->where('is_active', true);
    }

    public function markFetched(Source $source): void
    {
        $source->forceFill(['last_fetched_at' => now()])->save();
    }
}
