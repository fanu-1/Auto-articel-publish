@extends('layouts.admin')

@section('title', $rawArticle->title)

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <div class="text-sm text-slate-400">Source</div>
            <div class="mt-1">{{ $rawArticle->source?->name }}</div>
            <div class="mt-4 text-sm text-slate-400">Raw Content</div>
            <div class="mt-1 whitespace-pre-wrap text-sm leading-6 text-slate-200">{{ $rawArticle->content_raw }}</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <div class="text-sm text-slate-400">Clean Content</div>
            <div class="mt-1 whitespace-pre-wrap text-sm leading-6 text-slate-200">{{ $rawArticle->content_clean }}</div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <div class="text-sm text-slate-400">Pipeline</div>
            <div class="mt-2 text-lg font-semibold">{{ $rawArticle->status }}</div>
            <form class="mt-4" action="{{ route('admin.raw-articles.update', $rawArticle) }}" method="POST">
                @method('PATCH')
                @csrf
                <input type="hidden" name="run_cleaning" value="1">
                <button class="w-full rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950">Run Cleaning</button>
            </form>
        </div>
    </div>
</div>
@endsection
