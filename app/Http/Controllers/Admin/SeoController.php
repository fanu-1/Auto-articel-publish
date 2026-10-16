<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiArticle;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        return view('admin.seo.index', [
            'articles' => AiArticle::latest()->paginate(15),
        ]);
    }
}
