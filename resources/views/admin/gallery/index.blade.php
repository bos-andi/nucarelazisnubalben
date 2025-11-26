@extends('layouts.admin')

@section('title', 'Kelola Galeri - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dashboard Media</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Galeri Foto &amp; Video</h1>
                <p class="text-sm text-slate-500 mt-1">Unggah dokumentasi kegiatan dan sematkan video YouTube/IG/TikTok.</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Tambah Media</a>
        </div>

        <div class="mt-8 grid md:grid-cols-3 gap-6">
            @forelse ($items as $item)
                <article class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ $item->thumbnail_url ?? $item->media_url }}" alt="{{ $item->title }}" class="h-48 w-full object-cover">
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs rounded-full {{ $item->type === 'video' ? 'bg-black/80 text-white' : 'bg-white/90 text-slate-700' }}">
                            {{ ucfirst($item->type) }}
                        </span>
                        @if($item->is_featured)
                            <span class="absolute top-3 right-3 px-3 py-1 text-xs rounded-full bg-nu-600 text-white">Sorotan</span>
                        @endif
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-xs uppercase tracking-[0.3em] text-nu-500">{{ $item->type === 'video' ? 'Video' : 'Foto' }}</p>
                        <h2 class="text-lg font-semibold text-slate-900 mt-2">{{ $item->title }}</h2>
                        <p class="text-sm text-slate-600 mt-2 flex-1">{{ Str::limit($item->description, 120) }}</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                            <span>{{ optional($item->published_at)->translatedFormat('d M Y') }}</span>
                            <a href="{{ $item->media_url }}" target="_blank" class="text-nu-600 font-semibold">Buka media</a>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus item galeri ini?')" class="text-xs font-semibold text-red-500">
                                @csrf
                                @method('DELETE')
                                <button>Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="md:col-span-3 text-center text-slate-500 py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                    Belum ada dokumentasi.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

