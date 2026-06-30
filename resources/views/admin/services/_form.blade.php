<div>
    <label for="name" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['name'] }}</label>
    <input type="text" name="name" id="name" value="{{ old('name', $service->name ?? '') }}" required class="h-11 w-full rounded border border-border px-3 text-sm">
</div>
<div>
    <label for="icon_svg" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['icon_svg'] }}</label>
    <textarea name="icon_svg" id="icon_svg" rows="6" required class="w-full rounded border border-border px-3 py-2 font-mono text-xs" dir="ltr">{{ old('icon_svg', $service->icon_svg ?? '') }}</textarea>
</div>
<div>
    <label for="description" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['description'] ?? 'الوصف' }}</label>
    <textarea name="description" id="description" rows="3" class="w-full rounded border border-border px-3 py-2 text-sm">{{ old('description', $service->description ?? '') }}</textarea>
</div>
<div>
    <label for="price" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['price'] ?? 'السعر' }}</label>
    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $service->price ?? '') }}" class="h-11 w-full rounded border border-border px-3 text-sm">
</div>
<div>
    <label for="sort_order" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['sort_order'] }}</label>
    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0" class="h-11 w-full rounded border border-border px-3 text-sm">
</div>
<label class="flex items-center gap-2 text-sm">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true)) class="rounded border-border text-primary">
    <span>{{ $fieldLabels['is_active'] }}</span>
</label>
