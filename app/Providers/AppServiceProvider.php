<?php

namespace App\Providers;

use App\Services\AI\OpenAIService;
use App\Services\AI\PromptService;
use App\Services\ContentCleaner;
use App\Services\FactExtractionService;
use App\Services\InternalLinking\InternalLinkingService;
use App\Services\Quality\QualityReviewService;
use App\Services\SEO\SeoService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PromptService::class);
        $this->app->singleton(OpenAIService::class);
        $this->app->singleton(ContentCleaner::class);
        $this->app->singleton(FactExtractionService::class);
        $this->app->singleton(QualityReviewService::class);
        $this->app->singleton(SeoService::class);
        $this->app->singleton(InternalLinkingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
