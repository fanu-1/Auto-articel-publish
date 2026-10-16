<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(): View
    {
        $path = storage_path('logs/laravel.log');
        $contents = File::exists($path) ? File::get($path) : '';
        $lines = array_slice(preg_split('/\R/', trim($contents)) ?: [], -200);

        return view('admin.logs.index', [
            'lines' => $lines,
        ]);
    }
}
