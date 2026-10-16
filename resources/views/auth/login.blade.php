@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/90 p-8 shadow-2xl">
    <h1 class="text-2xl font-semibold">Sign in</h1>
    <p class="mt-2 text-sm text-slate-400">Access the publishing control room.</p>

    <form class="mt-6 space-y-4" method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label class="mb-1 block text-sm text-slate-300">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required autofocus>
            @error('email')
                <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm text-slate-300">Password</label>
            <input name="password" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
            @error('password')
                <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-950">
            Remember me
        </label>

        <button class="w-full rounded-lg bg-emerald-400 px-4 py-3 font-semibold text-slate-950">Login</button>
    </form>

    <p class="mt-6 text-sm text-slate-400">
        Need an account? <a class="text-emerald-300" href="{{ route('register') }}">Create one</a>
    </p>
</div>
@endsection
