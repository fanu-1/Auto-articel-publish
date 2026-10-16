<?php

namespace Database\Seeders;

use App\Actions\Pipeline\PublishArticleAction;
use App\Models\AiArticle;
use App\Models\ArticleFact;
use App\Models\ArticleFaq;
use App\Models\ArticleImage;
use App\Models\ArticleLink;
use App\Models\Category;
use App\Models\Entity;
use App\Models\RawArticle;
use App\Models\Setting;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $category = Category::query()->updateOrCreate(
            ['slug' => 'technology'],
            [
                'name' => 'Technology',
                'description' => 'Tech, AI, and product knowledge.',
                'is_active' => true,
            ]
        );

        Source::query()->updateOrCreate(
            ['url' => 'https://example.com/feed.xml'],
            [
                'name' => 'Example RSS Feed',
                'type' => 'rss',
                'is_active' => true,
                'metadata' => ['demo' => true],
            ]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'publishing.auto_publish'],
            ['value' => 'false', 'group' => 'publishing', 'type' => 'bool']
        );

        Setting::query()->updateOrCreate(
            ['key' => 'content.default_word_target'],
            ['value' => '1400', 'group' => 'content', 'type' => 'integer']
        );

        $rawArticle = RawArticle::query()->updateOrCreate(
            ['url' => 'https://example.com/articles/ai-knowledge-workflows'],
            [
                'source_id' => Source::first()->id,
                'category_id' => $category->id,
                'title' => 'AI Knowledge Workflows for Local Publishing',
                'canonical_url' => 'https://example.com/articles/ai-knowledge-workflows',
                'excerpt' => 'A short example article used to seed the local dashboard.',
                'content_raw' => '<p>Local publishing teams can use AI to transform feeds into structured knowledge articles.</p><p>The important step is editorial synthesis, not rewriting.</p>',
                'content_clean' => 'Local publishing teams can use AI to transform feeds into structured knowledge articles. The important step is editorial synthesis, not rewriting.',
                'content_hash' => hash('sha256', 'https://example.com/articles/ai-knowledge-workflows'),
                'language' => 'en',
                'status' => 'cleaned',
                'fetched_at' => now(),
                'cleaned_at' => now(),
                'metadata' => ['demo' => true],
            ]
        );

        $fact = ArticleFact::query()->updateOrCreate(
            ['raw_article_id' => $rawArticle->id],
            [
                'facts' => [
                    'AI can transform feed items into knowledge articles.',
                    'Editorial synthesis is more valuable than rewriting.',
                ],
                'summary' => 'A sample article about transforming feeds into useful knowledge.',
                'confidence' => 90,
                'model' => 'demo',
            ]
        );

        $article = AiArticle::query()->updateOrCreate(
            ['raw_article_id' => $rawArticle->id],
            [
                'category_id' => $category->id,
                'title' => 'How AI Turns Feed Items into Knowledge Articles',
                'slug' => Str::slug('How AI Turns Feed Items into Knowledge Articles').'-'.$rawArticle->id,
                'content' => '<h2>How AI Turns Feed Items into Knowledge Articles</h2><p>Useful publishing systems do more than rewrite source text. They isolate facts, add context, and present practical knowledge.</p>',
                'summary' => 'A sample generated article showing the knowledge-first publishing workflow.',
                'context' => json_encode([
                    'facts' => $fact->facts,
                    'related_articles' => [],
                ], JSON_PRETTY_PRINT),
                'status' => 'draft',
                'word_count' => 28,
                'quality_score' => 84,
                'seo_title' => 'AI Knowledge Publishing Workflow',
                'seo_description' => 'Learn how to turn feed content into useful knowledge articles.',
                'seo_keywords' => ['AI publishing', 'knowledge articles', 'content workflow'],
            ]
        );

        ArticleFaq::query()->updateOrCreate(
            ['ai_article_id' => $article->id, 'question' => 'What makes this different from rewriting?'],
            ['answer' => 'It adds context, structure, and editorial value instead of echoing the source.', 'sort_order' => 0]
        );

        ArticleImage::query()->updateOrCreate(
            ['ai_article_id' => $article->id, 'url' => 'https://placehold.co/1200x630'],
            [
                'alt_text' => 'Knowledge publishing preview image',
                'source_url' => 'https://placehold.co/1200x630',
                'sort_order' => 0,
            ]
        );

        Entity::query()->updateOrCreate(
            ['ai_article_id' => $article->id, 'name' => 'AI'],
            [
                'type' => 'technology',
                'value' => 'Artificial intelligence',
                'is_primary' => true,
                'metadata' => ['demo' => true],
            ]
        );

        ArticleLink::query()->updateOrCreate(
            ['ai_article_id' => $article->id, 'anchor_text' => 'knowledge-first workflow'],
            [
                'linked_ai_article_id' => null,
                'relationship_type' => 'related',
                'score' => 65,
                'metadata' => ['demo' => true],
            ]
        );

        app(PublishArticleAction::class)->execute($article);
        $article->forceFill(['status' => 'draft', 'published_at' => null])->save();
    }
}
