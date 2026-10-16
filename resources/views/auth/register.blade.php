@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/90 p-8 shadow-2xl">
    <h1 class="text-2xl font-semibold">Create account</h1>
    <p class="mt-2 text-sm text-slate-400">Set up the first admin user for local development.</p>

    <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label class="mb-1 block text-sm text-slate-300">Name</label>
            <input name="name" type="text" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required autofocus>
            @error('name')
                <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm text-slate-300">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
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

        <div>
            <label class="mb-1 block text-sm text-slate-300">Confirm password</label>
            <input name="password_confirmation" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
        </div>

        <button class="w-full rounded-lg bg-emerald-400 px-4 py-3 font-semibold text-slate-950">Create account</button>
    </form>

    <p class="mt-6 text-sm text-slate-400">
        Already have an account? <a class="text-emerald-300" href="{{ route('login') }}">Sign in</a>
    </p>
</div>
@endsection
