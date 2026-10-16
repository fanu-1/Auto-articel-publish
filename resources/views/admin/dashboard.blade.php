@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Sources</div>
        <div class="mt-2 text-3xl font-semibold">{{ $sources }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Raw Articles</div>
        <div class="mt-2 text-3xl font-semibold">{{ $rawArticles }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Generated Articles</div>
        <div class="mt-2 text-3xl font-semibold">{{ $articles }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Published</div>
        <div class="mt-2 text-3xl font-semibold">{{ $publishedArticles }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Entities</div>
        <div class="mt-2 text-3xl font-semibold">{{ $entities }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Settings</div>
        <div class="mt-2 text-3xl font-semibold">{{ $settings }}</div>
    </div>
</div>

<div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900 p-5">
    <h2 class="text-lg font-semibold">Recent articles</h2>
    <div class="mt-4 space-y-3">
        @forelse ($recentArticles as $article)
            <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950 px-4 py-3">
                <div>
                    <div class="font-medium">{{ $article->title }}</div>
                    <div class="text-sm text-slate-400">{{ $article->status }}</div>
                </div>
                <a class="text-sm text-emerald-300" href="{{ route('admin.articles.show', $article) }}">Open</a>
            </div>
        @empty
            <p class="text-sm text-slate-400">No articles yet.</p>
        @endforelse
    </div>
</div>
@endsection
