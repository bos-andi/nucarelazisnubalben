@extends('layouts.admin')

@section('title', 'Tambah Khutbah Jum\'at')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Khutbah Jum'at Baru</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Tambah Khutbah Jum'at</h1>
            </div>
            <a href="{{ route('admin.khutbah.index') }}" class="text-sm font-semibold text-slate-500">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="mt-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-600 text-sm">
                <p class="font-semibold">Periksa kembali:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.khutbah.store') }}" method="POST" class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 p-8 space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-semibold text-slate-600">Judul Khutbah *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"
                           placeholder="Contoh: Khutbah Jum'at tentang Keutamaan Shalat">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-600">Slug (opsional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"
                           placeholder="otomatis bila dikosongkan">
                    <p class="text-xs text-slate-400 mt-1">URL-friendly version dari judul</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="text-sm font-semibold text-slate-600">Tanggal Khutbah *</label>
                    <input type="date" name="khutbah_date" value="{{ old('khutbah_date') }}" required
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-600">Nama Khatib</label>
                    <input type="text" name="khatib" value="{{ old('khatib') }}"
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"
                           placeholder="Nama khatib">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-600">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"
                           placeholder="Masjid/Musholla">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600">Konten Khutbah *</label>
                <input type="hidden" name="content" id="body-input" value="{{ old('content') }}" required>
                <div id="quill-editor" class="mt-2 bg-white rounded-2xl border border-slate-200" style="min-height: 400px;"></div>
                <p class="text-xs text-slate-400 mt-1">Gunakan toolbar untuk format teks (bold, italic), tambah gambar, link, dll. Anda bisa menulis dalam bahasa Arab dan Indonesia dalam satu editor.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">Status Publikasi</label>
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                           class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                    <label for="is_published" class="ml-2 text-sm text-slate-600">Publikasikan khutbah ini</label>
                </div>
                <p class="text-xs text-slate-400 mt-1">Jika dicentang, khutbah akan langsung tampil di halaman publik</p>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-nu-600 hover:bg-nu-700 text-white font-semibold px-6 py-3 rounded-2xl">
                    Simpan Khutbah
                </button>
                <a href="{{ route('admin.khutbah.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
