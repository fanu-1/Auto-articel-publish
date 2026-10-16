@extends('layouts.admin')

@section('title', 'Sources')

@section('content')
<div class="mb-4 flex justify-end">
    <a class="rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950" href="{{ route('admin.sources.create') }}">New Source</a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
    <table class="min-w-full divide-y divide-slate-800 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-left">URL</th>
                <th class="px-4 py-3 text-left">Active</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach ($sources as $source)
                <tr>
                    <td class="px-4 py-3">{{ $source->name }}</td>
                    <td class="px-4 py-3">{{ $source->type }}</td>
                    <td class="px-4 py-3 break-all">{{ $source->url }}</td>
                    <td class="px-4 py-3">{{ $source->is_active ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-emerald-300" href="{{ route('admin.sources.edit', $source) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $sources->links() }}</div>
@endsection
