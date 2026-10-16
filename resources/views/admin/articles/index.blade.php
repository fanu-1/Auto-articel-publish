@extends('layouts.admin')

@section('title', 'Generated Articles')

@section('content')
<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
    <table class="min-w-full divide-y divide-slate-800 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">SEO</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach ($articles as $article)
                <tr>
                    <td class="px-4 py-3">{{ $article->title }}</td>
                    <td class="px-4 py-3">{{ $article->status }}</td>
                    <td class="px-4 py-3">{{ $article->seo_title ? 'Ready' : 'Pending' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-emerald-300" href="{{ route('admin.articles.show', $article) }}">Open</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $articles->links() }}</div>
@endsection
