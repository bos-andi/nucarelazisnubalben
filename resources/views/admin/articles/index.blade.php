@extends('layouts.admin')

@section('title', 'Kelola Berita - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dashboard</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Kelola Berita</h1>
                <p class="text-sm text-slate-500 mt-1">Tambah, ubah, dan publikasikan kabar terbaru Lazisnu.</p>
            </div>
            <a href="{{ route('admin.articles.create') }}" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Tambah Berita</a>
        </div>

        <form method="GET" class="mt-8 grid md:grid-cols-3 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis..." class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
            <select name="category_id" class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-semibold">Terapkan</button>
        </form>

        <div class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                <tr>
                    <th class="text-left px-6 py-4">Judul</th>
                    <th class="text-left px-6 py-4">Kategori</th>
                    <th class="text-left px-6 py-4">Penulis</th>
                    <th class="text-left px-6 py-4">Terbit</th>
                    <th class="text-center px-6 py-4">Unggulan</th>
                    <th class="px-6 py-4"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($articles as $article)
                    <tr class="border-t border-slate-100 hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $article->title }}</p>
                            <p class="text-xs text-slate-500">Slug: {{ $article->slug }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $article->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $article->author ?? 'Tim Lazisnu' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ optional($article->published_at)->translatedFormat('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($article->is_featured)
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-nu-100 text-nu-700">Ya</span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex flex-wrap gap-2">
                            <a href="{{ route('articles.show', $article) }}" target="_blank" class="text-nu-600 text-xs font-semibold">Lihat</a>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-500">Belum ada berita.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection

