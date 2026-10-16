<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntityController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\RawArticleController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore']);
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('sources', SourceController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('raw-articles', RawArticleController::class)->only(['index', 'show', 'update']);
    Route::resource('articles', ArticleController::class)->only(['index', 'show', 'update']);
    Route::resource('entities', EntityController::class)->only(['index']);
    Route::resource('seo', SeoController::class)->only(['index']);
    Route::resource('queues', QueueController::class)->only(['index']);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::resource('logs', LogController::class)->only(['index']);
});
