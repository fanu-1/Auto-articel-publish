@extends('layouts.admin')

@section('title', 'Queues')

@section('content')
<div class="grid gap-4 md:grid-cols-2">
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Pending Jobs</div>
        <div class="mt-2 text-3xl font-semibold">{{ $pendingJobs }}</div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="text-sm text-slate-400">Failed Jobs</div>
        <div class="mt-2 text-3xl font-semibold">{{ $failedJobs }}</div>
    </div>
</div>

<div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900 p-5">
    <h2 class="text-lg font-semibold">Recent failed jobs</h2>
    <div class="mt-4 space-y-3">
        @forelse ($recentFailedJobs as $failedJob)
            <div class="rounded-xl border border-slate-800 bg-slate-950 p-4 text-sm">
                <div class="font-medium">{{ $failedJob->uuid ?? 'Failed job' }}</div>
                <div class="mt-1 text-slate-400">{{ $failedJob->exception ?? 'No exception recorded.' }}</div>
            </div>
        @empty
            <p class="text-sm text-slate-400">No failed jobs yet.</p>
        @endforelse
    </div>
</div>
@endsection
