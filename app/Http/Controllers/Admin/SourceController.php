<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SourceController extends Controller
{
    public function index(): View
    {
        return view('admin.sources.index', [
            'sources' => Source::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.sources.create', [
            'source' => new Source(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'url' => ['required', 'url', 'max:255', 'unique:sources,url'],
            'extraction_rules' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Source::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'url' => $data['url'],
            'extraction_rules' => $this->decodeJson($data['extraction_rules'] ?? null),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sources.index')->with('status', 'Source created.');
    }

    public function edit(Source $source): View
    {
        return view('admin.sources.edit', compact('source'));
    }

    public function update(Request $request, Source $source): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'url' => ['required', 'url', 'max:255', 'unique:sources,url,'.$source->id],
            'extraction_rules' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $source->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'url' => $data['url'],
            'extraction_rules' => $this->decodeJson($data['extraction_rules'] ?? null),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sources.index')->with('status', 'Source updated.');
    }

    public function destroy(Source $source): RedirectResponse
    {
        $source->delete();

        return redirect()->route('admin.sources.index')->with('status', 'Source deleted.');
    }

    private function decodeJson(?string $payload): array|null
    {
        if (! $payload) {
            return null;
        }

        $decoded = json_decode($payload, true);

        return is_array($decoded) ? $decoded : null;
    }
}
