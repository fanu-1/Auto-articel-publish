@extends('layouts.admin')

@section('title', 'Raw Articles')

@section('content')
<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
    <table class="min-w-full divide-y divide-slate-800 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Source</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Fetched</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach ($rawArticles as $rawArticle)
                <tr>
                    <td class="px-4 py-3">{{ $rawArticle->title }}</td>
                    <td class="px-4 py-3">{{ $rawArticle->source?->name }}</td>
                    <td class="px-4 py-3">{{ $rawArticle->status }}</td>
                    <td class="px-4 py-3">{{ optional($rawArticle->fetched_at)->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-emerald-300" href="{{ route('admin.raw-articles.show', $rawArticle) }}">Open</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $rawArticles->links() }}</div>
@endsection
