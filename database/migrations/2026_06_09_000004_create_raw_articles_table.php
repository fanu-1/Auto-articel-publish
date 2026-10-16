<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_articles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('url')->unique();
            $table->string('canonical_url')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content_raw');
            $table->longText('content_clean')->nullable();
            $table->string('content_hash', 64)->unique();
            $table->string('language', 10)->default('en');
            $table->string('status')->default('fetched');
            $table->timestamp('fetched_at')->nullable();
            $table->timestamp('cleaned_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_articles');
    }
};
