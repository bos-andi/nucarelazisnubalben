@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri Lazisnu Balongbendo')
@section('meta_description', Str::limit($gallery->description ?: $gallery->title, 160))
@section('meta_keywords', 'galeri Lazisnu, ' . $gallery->title . ', foto kegiatan NU, dokumentasi Lazisnu Balongbendo')

@section('og_title', $gallery->title . ' - Galeri Lazisnu Balongbendo')
@section('og_description', Str::limit($gallery->description ?: $gallery->title, 200))
@php
    // Use first photo from photos array if available, otherwise use media_url
    $ogImage = null;
    if ($gallery->photos && is_array($gallery->photos) && count($gallery->photos) > 0) {
        $ogImage = $gallery->photos[0];
    } else {
        $ogImage = $gallery->media_url;
    }
    // Ensure absolute URL
    if (!$ogImage) {
        $ogImage = asset('images/lazisnu-og-default.svg');
    }
    $ogImage = str_starts_with($ogImage, 'http') ? $ogImage : url($ogImage);
@endphp
@section('og_image', $ogImage)
@section('og_url', route('gallery.show', $gallery))
@section('og_type', 'article')
@section('og_image_alt', $gallery->title)

@section('twitter_title', $gallery->title . ' - Galeri Lazisnu Balongbendo')
@section('twitter_description', Str::limit($gallery->description ?: $gallery->title, 200))
@section('twitter_image', $ogImage)

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
                @php
                    // Get all photos - use photos array if available, otherwise fallback to media_url
                    $photos = $gallery->photos && is_array($gallery->photos) && count($gallery->photos) > 0 
                        ? $gallery->photos 
                        : ($gallery->media_url ? [$gallery->media_url] : []);
                @endphp
                
                @if(count($photos) > 1)
                    <!-- Multiple Photos Grid -->
                    <div class="mb-6">
                        <p class="text-sm text-slate-600 mb-4 text-center">
                            <span class="font-semibold">{{ count($photos) }}</span> foto dalam galeri ini
                        </p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="gallery-grid">
                            @foreach($photos as $index => $photo)
                                <div class="relative group cursor-pointer" onclick="openLightbox({{ $index }})">
                                    <img src="{{ $photo }}" alt="{{ $gallery->title }} - Foto {{ $index + 1 }}" 
                                         class="w-full h-48 object-cover rounded-lg border-2 border-slate-200 group-hover:border-nu-500 transition-all shadow-sm group-hover:shadow-md">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-lg"></div>
                                    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{ $index + 1 }}/{{ count($photos) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Lightbox Modal -->
                    <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center" onclick="closeLightbox()">
                        <div class="relative max-w-6xl w-full mx-4" onclick="event.stopPropagation()">
                            <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black/50 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <button onclick="previousPhoto()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 z-10 bg-black/50 rounded-full p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="nextPhoto()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 z-10 bg-black/50 rounded-full p-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <img id="lightbox-image" src="" alt="{{ $gallery->title }}" class="w-full h-auto max-h-[90vh] object-contain rounded-lg">
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white bg-black/50 px-4 py-2 rounded-full text-sm">
                                <span id="photo-counter"></span>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        const photos = @json($photos);
                        let currentPhotoIndex = 0;
                        
                        function openLightbox(index) {
                            currentPhotoIndex = index;
                            updateLightbox();
                            document.getElementById('lightbox').classList.remove('hidden');
                            document.getElementById('lightbox').classList.add('flex');
                            document.body.style.overflow = 'hidden';
                        }
                        
                        function closeLightbox() {
                            document.getElementById('lightbox').classList.add('hidden');
                            document.getElementById('lightbox').classList.remove('flex');
                            document.body.style.overflow = '';
                        }
                        
                        function updateLightbox() {
                            document.getElementById('lightbox-image').src = photos[currentPhotoIndex];
                            document.getElementById('photo-counter').textContent = `${currentPhotoIndex + 1} / ${photos.length}`;
                        }
                        
                        function nextPhoto() {
                            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
                            updateLightbox();
                        }
                        
                        function previousPhoto() {
                            currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
                            updateLightbox();
                        }
                        
                        // Keyboard navigation
                        document.addEventListener('keydown', function(e) {
                            const lightbox = document.getElementById('lightbox');
                            if (!lightbox.classList.contains('hidden')) {
                                if (e.key === 'Escape') closeLightbox();
                                if (e.key === 'ArrowRight') nextPhoto();
                                if (e.key === 'ArrowLeft') previousPhoto();
                            }
                        });
                    </script>
                @else
                    <!-- Single Photo -->
                    <div class="text-center">
                        <img src="{{ $gallery->media_url }}" alt="{{ $gallery->title }}" class="w-full max-w-3xl mx-auto rounded-2xl shadow-lg">
                    </div>
                @endif
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
