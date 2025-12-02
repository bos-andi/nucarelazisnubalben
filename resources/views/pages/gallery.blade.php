@extends('layouts.app')

@section('title', 'Galeri Lazisnu Balongbendo')
@section('meta_description', 'Galeri foto dan video kegiatan Lazisnu MWC NU Balongbendo. Dokumentasi aksi sosial, khutbah inspiratif, hingga respon kebencanaan untuk jamaah Nahdliyin.')
@section('meta_keywords', 'galeri Lazisnu, foto kegiatan NU, video Lazisnu Balongbendo, dokumentasi program sosial, galeri NU Balongbendo')

@section('og_title', 'Galeri Foto & Video - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Galeri foto dan video kegiatan Lazisnu MWC NU Balongbendo. Dokumentasi aksi sosial, khutbah inspiratif, hingga respon kebencanaan untuk jamaah Nahdliyin.')
@section('og_url', route('gallery'))
@section('og_type', 'website')

@section('twitter_title', 'Galeri Foto & Video - Lazisnu MWC NU Balongbendo')
@section('twitter_description', 'Galeri foto dan video kegiatan Lazisnu MWC NU Balongbendo. Dokumentasi aksi sosial, khutbah inspiratif, hingga respon kebencanaan untuk jamaah Nahdliyin.')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-5xl mx-auto px-6 py-12 text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Dokumentasi</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">Galeri Foto &amp; Video Kegiatan</h1>
            <p class="text-nu-100 mt-4">Sorotan aksi sosial, khutbah inspiratif, hingga respon kebencanaan Lazisnu MWC NU Balongbendo.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 -mt-12 relative">
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Foto Terbaru</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @forelse ($photos as $photo)
                    @php
                        $photoCount = $photo->photos && is_array($photo->photos) && count($photo->photos) > 0 
                            ? count($photo->photos) 
                            : ($photo->media_url ? 1 : 0);
                    @endphp
                    <a href="{{ route('gallery.show', $photo) }}" class="group rounded-3xl overflow-hidden border border-slate-100 shadow hover:shadow-lg transition-all duration-300">
                        <div class="relative overflow-hidden">
                            <img src="{{ $photo->media_url }}" alt="{{ $photo->title }}" class="h-52 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                            @if($photoCount > 1)
                                <div class="absolute top-3 right-3 bg-black/70 text-white text-xs px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $photoCount }} foto</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="bg-white/90 rounded-full p-3">
                                    <svg class="w-6 h-6 text-nu-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 space-y-2">
                            <p class="text-xs uppercase tracking-[0.3em] text-nu-600">{{ optional($photo->published_at)->translatedFormat('d M Y') }}</p>
                            <h3 class="text-lg font-semibold text-slate-900 group-hover:text-nu-600 transition-colors">{{ $photo->title }}</h3>
                            <p class="text-sm text-slate-600">{{ Str::limit($photo->description, 100) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-3 text-center text-slate-500 py-12">Belum ada foto.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 mt-12">
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Video Inspiratif</h2>
            <div class="grid md:grid-cols-2 gap-8">
                @forelse ($videos as $video)
                    <a href="{{ route('gallery.show', $video) }}" class="group rounded-3xl border border-slate-100 shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-video relative">
                            @php
                                $videoInfo = \App\Helpers\YouTubeHelper::getVideoInfo($video->media_url);
                            @endphp
                            
                            @if ($videoInfo['is_youtube'])
                                <img src="{{ $videoInfo['thumbnail_url'] }}" 
                                     alt="{{ $video->title }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                
                                <!-- Fallback for when thumbnail fails to load -->
                                <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-700 text-white flex items-center justify-center" style="display: none;">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        <p class="text-sm font-semibold">YouTube Video</p>
                                        <p class="text-xs opacity-75">Klik untuk memutar</p>
                                    </div>
                                </div>
                                
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="bg-red-600 hover:bg-red-700 rounded-full p-4 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="absolute top-3 right-3 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    YouTube
                                </div>
                            @else
                                <div class="w-full h-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-slate-800 transition-colors">
                                    <svg class="w-12 h-12 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                    Tonton Video
                                </div>
                            @endif
                        </div>
                        <div class="p-5 space-y-2">
                            <p class="text-xs uppercase tracking-[0.3em] text-nu-600">{{ $videoInfo['is_youtube'] ? 'YouTube' : 'Video' }}</p>
                            <h3 class="text-lg font-semibold text-slate-900 group-hover:text-nu-600 transition-colors">{{ $video->title }}</h3>
                            <p class="text-sm text-slate-600">{{ Str::limit($video->description, 120) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-2 text-center text-slate-500 py-12">Belum ada video.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

