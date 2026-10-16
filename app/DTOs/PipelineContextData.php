<?php

namespace App\DTOs;

readonly class PipelineContextData
{
    public function __construct(
        public int $rawArticleId,
        public ?int $aiArticleId = null,
        public array $facts = [],
        public array $entities = [],
        public array $relatedArticles = [],
        public array $settings = [],
    ) {
    }
}
