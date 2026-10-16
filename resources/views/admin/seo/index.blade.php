@extends('layouts.admin')

@section('title', 'SEO')

@section('content')
<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
    <table class="min-w-full divide-y divide-slate-800 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">SEO Title</th>
                <th class="px-4 py-3 text-left">Description</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach ($articles as $article)
                <tr>
                    <td class="px-4 py-3">{{ $article->title }}</td>
                    <td class="px-4 py-3">{{ $article->seo_title ?? 'Pending' }}</td>
                    <td class="px-4 py-3">{{ $article->seo_description ?? 'Pending' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $articles->links() }}</div>
@endsection
