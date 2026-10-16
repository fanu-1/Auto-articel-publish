@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-6">
    @method('PUT')
    @csrf
    @foreach ($settings as $setting)
        <div>
            <label class="mb-1 block text-sm">{{ $setting->key }}</label>
            <input name="settings[{{ $setting->key }}]" value="{{ data_get(old('settings', []), $setting->key, $setting->value) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3">
        </div>
    @endforeach

    <div class="flex justify-end">
        <button class="rounded-lg bg-emerald-400 px-4 py-2 font-medium text-slate-950">Save settings</button>
    </div>
</form>
@endsection
