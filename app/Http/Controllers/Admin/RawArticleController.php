<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CleanContentJob;
use App\Models\RawArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RawArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.raw-articles.index', [
            'rawArticles' => RawArticle::with('source')->latest()->paginate(15),
        ]);
    }

    public function show(RawArticle $rawArticle): View
    {
        return view('admin.raw-articles.show', compact('rawArticle'));
    }

    public function update(Request $request, RawArticle $rawArticle): RedirectResponse
    {
        if ($request->boolean('run_cleaning')) {
            CleanContentJob::dispatch($rawArticle->id);
        }

        return back()->with('status', 'Raw article updated.');
    }
}
