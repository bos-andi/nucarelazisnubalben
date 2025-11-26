@extends('layouts.admin')

@section('title', 'Tambah Program')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900">Tambah Program Baru</h1>
            <p class="text-slate-600 mt-1">Tambahkan program Lazisnu yang akan ditampilkan di halaman utama</p>
        </div>

        <form action="{{ route('admin.programs.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul Program *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full rounded-lg border-slate-300 focus:border-nu-500 focus:ring-nu-500"
                           placeholder="Contoh: Sedekah Produktif">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-slate-700 mb-2">Icon (Emoji)</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                           class="w-full rounded-lg border-slate-300 focus:border-nu-500 focus:ring-nu-500"
                           placeholder="🌱" maxlength="10">
                    <p class="mt-1 text-xs text-slate-500">Gunakan emoji atau kosongkan jika tidak perlu</p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi *</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full rounded-lg border-slate-300 focus:border-nu-500 focus:ring-nu-500"
                          placeholder="Jelaskan program ini secara singkat...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full rounded-lg border-slate-300 focus:border-nu-500 focus:ring-nu-500"
                           placeholder="0">
                    <p class="mt-1 text-xs text-slate-500">Angka lebih kecil akan tampil lebih dulu</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                        <label for="is_active" class="ml-2 text-sm text-slate-700">Program aktif dan ditampilkan</label>
                    </div>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-slate-200">
                <button type="submit" class="bg-nu-600 text-white px-6 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                    Simpan Program
                </button>
                <a href="{{ route('admin.programs.index') }}" class="text-slate-600 hover:text-slate-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


