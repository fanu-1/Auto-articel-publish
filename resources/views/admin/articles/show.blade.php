@extends('layouts.admin')

@section('title', $article->title)

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <div class="prose prose-invert max-w-none">
                {!! $article->content !!}
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <h2 class="text-lg font-semibold">FAQs</h2>
            <div class="mt-4 space-y-3">
                @forelse ($article->faqs as $faq)
                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-4">
                        <div class="font-medium">{{ $faq->question }}</div>
                        <div class="mt-1 text-sm text-slate-300">{{ $faq->answer }}</div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No FAQs generated yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <div class="text-sm text-slate-400">Status</div>
            <div class="mt-1 text-lg font-semibold">{{ $article->status }}</div>
            <div class="mt-4 text-sm text-slate-400">SEO Title</div>
            <div>{{ $article->seo_title }}</div>
            <div class="mt-4 text-sm text-slate-400">SEO Description</div>
            <div class="text-sm">{{ $article->seo_description }}</div>
            <form class="mt-4" action="{{ route('admin.articles.update', $article) }}" method="POST">
                @method('PATCH')
                @csrf
                <input type="hidden" name="publish_now" value="1">
                <button class="w-full rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950">Manual Publish</button>
            </form>
        </div>
    </div>
</div>
@endsection
