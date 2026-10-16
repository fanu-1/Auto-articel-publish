<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_facts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('raw_article_id')->constrained()->cascadeOnDelete();
            $table->json('facts');
            $table->longText('summary')->nullable();
            $table->decimal('confidence', 5, 2)->default(0);
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_facts');
    }
};
