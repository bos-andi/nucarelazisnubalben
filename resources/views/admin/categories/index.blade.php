@extends('layouts.admin')

@section('title', 'Master Kategori - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Master Data</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Kategori Program &amp; Berita</h1>
                <p class="text-sm text-slate-500 mt-1">Hanya superadmin yang dapat mengatur daftar kategori.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Kategori Baru</a>
        </div>

        <div class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Slug</th>
                    <th class="px-6 py-4 text-left">Highlight</th>
                    <th class="px-6 py-4 text-right"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr class="border-t border-slate-100">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $category->name }}</p>
                            <p class="text-xs text-slate-500">{{ Str::limit($category->description, 80) }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            @if ($category->is_highlighted)
                                <span class="inline-flex px-3 py-1 text-xs rounded-full bg-nu-100 text-nu-700">Ya</span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex gap-3 justify-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-slate-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

