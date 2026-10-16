<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_links', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('ai_article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('linked_ai_article_id')->nullable()->constrained('ai_articles')->nullOnDelete();
            $table->string('anchor_text');
            $table->string('relationship_type')->default('related');
            $table->decimal('score', 5, 2)->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_links');
    }
};
