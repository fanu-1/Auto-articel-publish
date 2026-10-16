<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiArticle;
use App\Models\Entity;
use App\Models\RawArticle;
use App\Models\Setting;
use App\Models\Source;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'sources' => Source::count(),
            'rawArticles' => RawArticle::count(),
            'articles' => AiArticle::count(),
            'publishedArticles' => AiArticle::where('status', 'published')->count(),
            'entities' => Entity::count(),
            'settings' => Setting::count(),
            'recentArticles' => AiArticle::latest()->limit(5)->get(),
        ]);
    }
}
