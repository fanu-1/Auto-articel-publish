<?php

namespace App\Providers;

use App\Events\ArticlePublished;
use App\Listeners\LogArticlePublished;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ArticlePublished::class => [
            LogArticlePublished::class,
        ],
    ];
}
