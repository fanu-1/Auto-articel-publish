@extends('layouts.admin')

@section('title', 'Create Source')

@section('content')
<form action="{{ route('admin.sources.store') }}" method="POST" class="max-w-3xl rounded-2xl border border-slate-800 bg-slate-900 p-6">
    @include('admin.sources.form')
    <div class="mt-6 flex gap-3">
        <button class="rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950">Save</button>
        <a class="rounded-lg border border-slate-700 px-4 py-2" href="{{ route('admin.sources.index') }}">Cancel</a>
    </div>
</form>
@endsection
