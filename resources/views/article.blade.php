@extends('layouts.app')

@section('title', $article->title . ' - Lazisnu Balongbendo')

@section('meta_description', Str::limit(strip_tags($article->excerpt ?: $article->body), 160))
@section('meta_keywords', $article->tags->pluck('name')->implode(', ') . ', Lazisnu, NU, Balongbendo')
@section('meta_author', $article->author ?: 'Tim Lazisnu Balongbendo')

@section('og_title', $article->title)
@section('og_description', Str::limit(strip_tags($article->excerpt ?: $article->body), 200))
@php
    // Use thumbnail if available (optimized for social media), otherwise use cover_image
    $ogImage = $article->thumbnail ?: $article->cover_image;
    // Ensure absolute URL
    if (!$ogImage) {
        $ogImage = asset('images/lazisnu-og-default.svg');
    }
    $ogImage = str_starts_with($ogImage, 'http') ? $ogImage : url($ogImage);
@endphp
@section('og_image', $ogImage)
@section('og_url', route('articles.show', $article))
@section('og_type', 'article')
@section('og_image_alt', $article->title)

@section('twitter_title', $article->title)
@section('twitter_description', Str::limit(strip_tags($article->excerpt ?: $article->body), 200))
@section('twitter_image', $ogImage)

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ $article->title }}",
  "description": "{{ Str::limit(strip_tags($article->excerpt ?: $article->body), 200) }}",
  "image": "{{ $ogImage }}",
  "author": {
    "@type": "Person",
    "name": "{{ $article->author ?: 'Tim Lazisnu Balongbendo' }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Lazisnu MWC NU Balongbendo",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/lazisnu-logo.png') }}"
    }
  },
  "datePublished": "{{ $article->published_at ? $article->published_at->toISOString() : $article->created_at->toISOString() }}",
  "dateModified": "{{ $article->updated_at->toISOString() }}",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('articles.show', $article) }}"
  },
  "articleSection": "{{ $article->category->name ?? 'Berita' }}",
  "keywords": "{{ $article->tags->pluck('name')->implode(', ') }}"
}
</script>
@endpush

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-600 text-white">
        <div class="max-w-5xl mx-auto px-6 py-12">
            <div class="flex items-center gap-3 text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                <span>•</span>
                <span>Berita</span>
            </div>
            <p class="mt-4 text-sm text-nu-100">{{ $article->category->name ?? 'Program' }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4 leading-tight">{{ $article->title }}</h1>
            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-nu-100">
                @if($article->user)
                    <div class="flex items-center gap-2">
                        @if($article->user->avatar)
                            <img src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}" class="w-6 h-6 rounded-full object-cover border border-white/30">
                        @else
                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-semibold">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <span>Oleh <a href="{{ route('author.profile', $article->user->id) }}" class="hover:text-white underline">{{ $article->user->name }}</a></span>
                        @if($article->user->isSuperAdmin())
                            <!-- Superadmin Badge -->
                            <svg class="h-4 w-4 text-green-300" fill="currentColor" viewBox="0 0 20 20" title="Superadmin">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($article->user->isContributor() && $article->user->hasVerifiedKtp())
                            <!-- Verified Contributor Badge -->
                            <svg class="h-4 w-4 text-blue-300" fill="currentColor" viewBox="0 0 20 20" title="Kontributor Terverifikasi">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                @else
                    <span>Oleh {{ $article->author ?? 'Tim Lazisnu' }}</span>
                @endif
                <span>•</span>
                <span>{{ optional($article->published_at)->translatedFormat('l, d F Y') }}</span>
                <span>•</span>
                <span>{{ number_format($article->views) }} kali dilihat</span>
            </div>
            @if ($article->tags->count())
                <div class="mt-6 flex flex-wrap gap-2 text-xs">
                    @foreach ($article->tags as $tag)
                        <span class="px-3 py-1 rounded-full bg-white/10 text-white border border-white/30">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-6 -mt-20 relative">
        <div class="rounded-[32px] overflow-hidden shadow-2xl bg-white">
            @if ($article->cover_image)
                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-[420px] w-full object-cover">
            @else
                <div class="h-[420px] w-full bg-gradient-to-r from-nu-100 to-nu-200 flex items-center justify-center">
                    <div class="text-center text-nu-600">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm opacity-70">Gambar artikel tidak tersedia</p>
                    </div>
                </div>
            @endif
            <div class="p-10 prose prose-lg max-w-none">
                {!! $article->body !!}
                
                <!-- Social Share Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 not-prose">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Artikel Ini</h4>
                    <div class="flex flex-wrap gap-3">
                        <!-- WhatsApp -->
                        <a href="javascript:void(0)" onclick="shareToWhatsApp()" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </a>

                        <!-- WhatsApp Business -->
                        <a href="javascript:void(0)" onclick="shareToWhatsAppBusiness()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WA Business
                        </a>

                        <!-- Facebook -->
                        <a href="javascript:void(0)" onclick="shareToFacebook()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>

                        <!-- Instagram -->
                        <a href="javascript:void(0)" onclick="shareToInstagram()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            Instagram
                        </a>

                        <!-- TikTok -->
                        <a href="javascript:void(0)" onclick="shareToTikTok()" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                            TikTok
                        </a>

                        <!-- Copy Link -->
                        <button onclick="copyLink()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-6 mt-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Berita Lainnya</h2>
            <a href="{{ route('news') }}" class="text-sm font-semibold text-nu-600">Kembali ke halaman berita →</a>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            @forelse ($related as $item)
                <article class="p-6 rounded-3xl bg-white shadow-lg border border-slate-100 hover:border-nu-200 transition">
                    <div class="text-xs text-slate-500 flex justify-between">
                        <span class="font-semibold text-nu-600">{{ $item->category->name ?? 'Berita' }}</span>
                        <span>{{ optional($item->published_at)->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-slate-900">{{ $item->title }}</h3>
                    <p class="text-sm text-slate-600 mt-2">{{ Str::limit($item->excerpt, 160) }}</p>
                    <a href="{{ route('articles.show', $item) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm mt-4">Baca selengkapnya →</a>
                </article>
            @empty
                <p class="text-slate-500">Belum ada artikel lain.</p>
            @endforelse
        </div>
    </section>

    <script>
        const articleUrl = '{{ route("articles.show", $article) }}';
        const articleTitle = '{{ addslashes($article->title) }}';
        const articleDescription = '{{ addslashes(Str::limit(strip_tags($article->excerpt ?: $article->body), 100)) }}';

        function shareToWhatsApp() {
            const text = `${articleTitle}\n\n${articleDescription}\n\nBaca selengkapnya: ${articleUrl}`;
            const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        function shareToWhatsAppBusiness() {
            const text = `${articleTitle}\n\n${articleDescription}\n\nBaca selengkapnya: ${articleUrl}`;
            const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        function shareToFacebook() {
            const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(articleUrl)}`;
            window.open(url, '_blank', 'width=600,height=400');
        }

        function shareToInstagram() {
            // Instagram doesn't support direct URL sharing, so we copy the link and show instructions
            copyLink();
            alert('Link telah disalin! Buka Instagram dan paste link ini di story atau post Anda.');
        }

        function shareToTikTok() {
            // TikTok doesn't support direct URL sharing, so we copy the link and show instructions
            copyLink();
            alert('Link telah disalin! Buka TikTok dan paste link ini di bio atau komentar Anda.');
        }

        function copyLink() {
            navigator.clipboard.writeText(articleUrl).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Tersalin!';
                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = articleUrl;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Link berhasil disalin!');
            });
        }
    </script>
@endsection

