@extends('layouts.admin')

@section('title', 'Logs')

@section('content')
<div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
    <pre class="overflow-auto whitespace-pre-wrap text-xs leading-5 text-slate-300">@foreach ($lines as $line)
{{ $line }}
@endforeach</pre>
</div>
@endsection
