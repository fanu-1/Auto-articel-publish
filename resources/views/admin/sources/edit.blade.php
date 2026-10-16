@extends('layouts.admin')

@section('title', 'Edit Source')

@section('content')
<form action="{{ route('admin.sources.update', $source) }}" method="POST" class="max-w-3xl rounded-2xl border border-slate-800 bg-slate-900 p-6">
    @method('PUT')
    @include('admin.sources.form')
    <div class="mt-6 flex gap-3">
        <button class="rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950">Update</button>
        <a class="rounded-lg border border-slate-700 px-4 py-2" href="{{ route('admin.sources.index') }}">Cancel</a>
    </div>
</form>
@endsection
