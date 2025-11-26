@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri Lazisnu Balongbendo')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-5xl mx-auto px-6 py-12">
            <nav class="text-sm text-nu-100 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                <span class="mx-2">•</span>
                <a href="{{ route('gallery') }}" class="hover:text-white">Galeri</a>
                <span class="mx-2">•</span>
                <span>{{ $gallery->title }}</span>
            </nav>
            <div class="text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">{{ ucfirst($gallery->type) }}</p>
                <h1 class="text-3xl md:text-4xl font-bold mt-4">{{ $gallery->title }}</h1>
                <p class="text-nu-100 mt-4">{{ optional($gallery->published_at)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 -mt-12 relative">
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
            @if($gallery->type === 'photo')
                <div class="text-center">
                    <img src="{{ $gallery->media_url }}" alt="{{ $gallery->title }}" class="w-full max-w-3xl mx-auto rounded-2xl shadow-lg">
                </div>
            @else
                @php
                    $videoInfo = \App\Helpers\YouTubeHelper::getVideoInfo($gallery->media_url);
                @endphp
                
                @if ($videoInfo['is_youtube'])
                    <div class="aspect-video rounded-2xl overflow-hidden bg-black">
                        <div id="youtube-player" class="w-full h-full relative">
                            <!-- Thumbnail dengan play button -->
                            <div id="video-thumbnail" class="w-full h-full relative cursor-pointer group">
                                <img src="{{ $videoInfo['thumbnail_url'] }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                
                                <!-- Fallback for when thumbnail fails to load -->
                                <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-700 text-white flex items-center justify-center" style="display: none;">
                                    <div class="text-center">
                                        <svg class="w-20 h-20 mx-auto mb-3 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        <p class="text-lg font-semibold">YouTube Video</p>
                                        <p class="text-sm opacity-75">Klik untuk memutar video</p>
                                    </div>
                                </div>
                                
                                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="bg-red-600 hover:bg-red-700 rounded-full p-6 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="absolute top-4 right-4 bg-black/70 text-white text-sm px-3 py-1 rounded">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    YouTube
                                </div>
                            </div>
                            
                            <!-- YouTube iframe (hidden initially) -->
                            <iframe id="youtube-iframe" 
                                    src="" 
                                    frameborder="0" 
                                    allowfullscreen 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    class="w-full h-full hidden"></iframe>
                        </div>
                    </div>
                    
                    <script>
                        document.getElementById('video-thumbnail').addEventListener('click', function() {
                            const thumbnail = document.getElementById('video-thumbnail');
                            const iframe = document.getElementById('youtube-iframe');
                            
                            // Hide thumbnail and show iframe with autoplay
                            thumbnail.style.display = 'none';
                            iframe.src = '{{ $videoInfo["embed_url"] }}?autoplay=1&rel=0';
                            iframe.classList.remove('hidden');
                        });
                    </script>
                @else
                    <div class="aspect-video rounded-2xl overflow-hidden">
                        <a href="{{ $gallery->media_url }}" target="_blank" class="block w-full h-full bg-slate-900 text-white flex items-center justify-center text-lg font-semibold hover:bg-slate-800 transition-colors">
                            <svg class="w-16 h-16 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Putar Video
                        </a>
                    </div>
                @endif
            @endif

            @if($gallery->description)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Deskripsi</h2>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-600 leading-relaxed">{{ $gallery->description }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if($related->count() > 0)
        <section class="max-w-6xl mx-auto px-6 mt-12">
            <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">{{ ucfirst($gallery->type) }} Lainnya</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($related as $item)
                        <a href="{{ route('gallery.show', $item) }}" class="group rounded-3xl overflow-hidden border border-slate-100 shadow hover:shadow-lg transition-shadow">
                            <div class="relative">
                                @if($item->type === 'video')
                                    @php
                                        $relatedVideoInfo = \App\Helpers\YouTubeHelper::getVideoInfo($item->media_url);
                                    @endphp
                                    
                                    @if($relatedVideoInfo['is_youtube'])
                                        <img src="{{ $relatedVideoInfo['thumbnail_url'] }}" alt="{{ $item->title }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors duration-300"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="bg-red-600 rounded-full p-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-48 w-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-slate-800 transition-colors">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-black/70 text-white text-xs px-3 py-1 rounded-full">Video</span>
                                @else
                                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                            </div>
                            <div class="p-5 space-y-2">
                                <p class="text-xs uppercase tracking-[0.3em] text-nu-600">{{ optional($item->published_at)->translatedFormat('d M Y') }}</p>
                                <h3 class="text-lg font-semibold text-slate-900 group-hover:text-nu-600 transition-colors">{{ $item->title }}</h3>
                                <p class="text-sm text-slate-600">{{ Str::limit($item->description, 100) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
