@csrf
@if(isset($tag))
    @method('PUT')
@endif
<div class="space-y-5">
    <div>
        <label class="text-sm font-semibold text-slate-600">Nama Tag*</label>
        <input type="text" name="name" value="{{ old('name', $tag->name ?? null) }}" required class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Slug (opsional)</label>
        <input type="text" name="slug" value="{{ old('slug', $tag->slug ?? null) }}" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Warna Badge (opsional)</label>
        <input type="text" name="color" value="{{ old('color', $tag->color ?? null) }}" placeholder="#0ea5e9" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
</div>
<div class="mt-8 flex gap-3">
    <button class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700">Simpan</button>
    <a href="{{ route('admin.tags.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600">Batal</a>
</div>

