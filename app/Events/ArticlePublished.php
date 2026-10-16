<?php

namespace App\Events;

use App\Models\AiArticle;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticlePublished
{
    use Dispatchable, SerializesModels;

    public function __construct(public AiArticle $article)
    {
    }
}
