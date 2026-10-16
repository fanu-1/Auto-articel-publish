@csrf
<div class="space-y-4">
    <div>
        <label class="mb-1 block text-sm">Name</label>
        <input name="name" value="{{ old('name', $source->name) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-1 block text-sm">Type</label>
        <input name="type" value="{{ old('type', $source->type ?? 'rss') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-1 block text-sm">URL</label>
        <input name="url" value="{{ old('url', $source->url) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-1 block text-sm">Extraction Rules JSON</label>
        <textarea name="extraction_rules" rows="6" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3">{{ old('extraction_rules', json_encode($source->extraction_rules ?? [], JSON_PRETTY_PRINT)) }}</textarea>
    </div>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $source->is_active ?? true))>
        Active
    </label>
</div>
