<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Admin</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 border-r border-slate-800 bg-slate-900/90 p-6 lg:block">
            <div class="mb-8">
                <div class="text-lg font-semibold">{{ config('app.name') }}</div>
                <div class="text-sm text-slate-400">Knowledge publishing control plane</div>
            </div>
            <nav class="space-y-2 text-sm">
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.sources.index') }}">Sources</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.raw-articles.index') }}">Raw Articles</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.articles.index') }}">Generated Articles</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.entities.index') }}">Entities</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.seo.index') }}">SEO</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.queues.index') }}">Queues</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.settings.index') }}">Settings</a>
                <a class="block rounded-lg px-3 py-2 hover:bg-slate-800" href="{{ route('admin.logs.index') }}">Logs</a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="flex items-center justify-between border-b border-slate-800 bg-slate-900 px-6 py-4">
                <div>
                    <div class="text-sm text-slate-400">Admin Dashboard</div>
                    <h1 class="text-xl font-semibold">@yield('title', 'Overview')</h1>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900">Logout</button>
                </form>
            </header>

            <section class="p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
