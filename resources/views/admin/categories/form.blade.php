@csrf
@if(isset($category))
    @method('PUT')
@endif
<div class="space-y-5">
    <div>
        <label class="text-sm font-semibold text-slate-600">Nama Kategori*</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? null) }}" required class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Slug (opsional)</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug ?? null) }}" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Warna Badge (hex, opsional)</label>
        <input type="text" name="color" value="{{ old('color', $category->color ?? null) }}" placeholder="#16a34a" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Deskripsi</label>
        <textarea name="description" rows="3" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('description', $category->description ?? null) }}</textarea>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_highlighted" value="1" id="is_highlighted" class="rounded text-nu-600 focus:ring-nu-600" {{ old('is_highlighted', $category->is_highlighted ?? false) ? 'checked' : '' }}>
        <label for="is_highlighted" class="text-sm text-slate-600">Tampilkan di highlight beranda</label>
    </div>
</div>
<div class="mt-8 flex gap-3">
    <button class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700">Simpan</button>
    <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600">Batal</a>
</div>

