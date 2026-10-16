<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_articles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('raw_article_id')->constrained()->cascadeOnDelete()->unique();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->longText('summary')->nullable();
            $table->longText('context')->nullable();
            $table->json('quality_report')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('word_count')->default(0);
            $table->decimal('quality_score', 5, 2)->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 160)->nullable();
            $table->json('seo_keywords')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_articles');
    }
};
