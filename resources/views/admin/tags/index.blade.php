@extends('layouts.admin')

@section('title', 'Master Tag - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Master Data</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Tag Berita</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar tag untuk membantu klasifikasi berita.</p>
            </div>
            <a href="{{ route('admin.tags.create') }}" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Tag Baru</a>
        </div>

        <div class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Slug</th>
                    <th class="px-6 py-4 text-left">Warna</th>
                    <th class="px-6 py-4 text-right"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tags as $tag)
                    <tr class="border-t border-slate-100">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $tag->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $tag->slug }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            @if ($tag->color)
                                <span class="inline-flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background: {{ $tag->color }}"></span>
                                    {{ $tag->color }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex gap-3 justify-end">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-slate-500">Belum ada tag.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

