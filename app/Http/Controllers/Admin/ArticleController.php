<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Pipeline\PublishArticleAction;
use App\Http\Controllers\Controller;
use App\Jobs\PublishArticleJob;
use App\Models\AiArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => AiArticle::with('rawArticle')->latest()->paginate(15),
        ]);
    }

    public function show(AiArticle $article): View
    {
        return view('admin.articles.show', [
            'article' => $article->load(['faqs', 'links', 'images', 'rawArticle.source']),
        ]);
    }

    public function update(Request $request, AiArticle $article): RedirectResponse
    {
        if ($request->boolean('publish_now')) {
            app(PublishArticleAction::class)->execute($article);
            return redirect()->route('admin.articles.show', $article)->with('status', 'Article published.');
        }

        PublishArticleJob::dispatch($article->id, false);

        return redirect()->route('admin.articles.show', $article)->with('status', 'Publish job queued.');
    }
}
