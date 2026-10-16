@extends('layouts.admin')

@section('title', 'Entities')

@section('content')
<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
    <table class="min-w-full divide-y divide-slate-800 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3 text-left">Type</th>
                <th class="px-4 py-3 text-left">Primary</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach ($entities as $entity)
                <tr>
                    <td class="px-4 py-3">{{ $entity->name }}</td>
                    <td class="px-4 py-3">{{ $entity->type }}</td>
                    <td class="px-4 py-3">{{ $entity->is_primary ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $entities->links() }}</div>
@endsection
