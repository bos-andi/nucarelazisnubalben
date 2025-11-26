@extends('layouts.app')

@section('title', 'Profil Penulis: ' . $author->name . ' - Lazisnu Balongbendo')
@section('meta_description', 'Profil penulis ' . $author->name . ' di Lazisnu MWC NU Balongbendo. Lihat semua artikel dan kontribusi dalam menyebarkan informasi kegiatan dan program sosial.')
@section('meta_keywords', 'penulis Lazisnu, kontributor NU Balongbendo, artikel ' . $author->name . ', penulis berita NU')

@section('og_title', 'Profil Penulis: ' . $author->name . ' - Lazisnu Balongbendo')
@section('og_description', 'Profil penulis ' . $author->name . ' di Lazisnu MWC NU Balongbendo. Lihat semua artikel dan kontribusi dalam menyebarkan informasi kegiatan dan program sosial.')
@section('og_url', route('author.profile', $author->id))
@section('og_type', 'profile')
@section('og_image', $author->avatar ?: asset('images/lazisnu-og-default.svg'))

@section('twitter_title', 'Profil Penulis: ' . $author->name . ' - Lazisnu Balongbendo')
@section('twitter_description', 'Profil penulis ' . $author->name . ' di Lazisnu MWC NU Balongbendo. Lihat semua artikel dan kontribusi dalam menyebarkan informasi kegiatan dan program sosial.')
@section('twitter_image', $author->avatar ?: asset('images/lazisnu-og-default.svg'))

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-4xl mx-auto px-6 py-12 md:py-16 lg:py-20">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Author Photo -->
                <div class="flex-shrink-0">
                    @if($author->avatar)
                        <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white/20 shadow-2xl">
                    @else
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-nu-300 to-nu-500 flex items-center justify-center text-white text-4xl md:text-5xl font-bold border-4 border-white/20 shadow-2xl">
                            {{ strtoupper(substr($author->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <!-- Author Info -->
                <div class="text-center md:text-left">
                    <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Profil Penulis</p>
                    <h1 class="text-3xl md:text-4xl font-bold mt-2">{{ $author->name }}</h1>
                    <p class="text-nu-100 mt-2 text-lg">{{ ucfirst($author->role) }}</p>
                    @if($author->bio)
                        <p class="text-nu-100 mt-4 max-w-2xl">{{ $author->bio }}</p>
                    @endif
                    <div class="mt-6 flex flex-wrap gap-4 justify-center md:justify-start">
                        <div class="bg-white/10 rounded-full px-4 py-2">
                            <span class="text-sm font-semibold">{{ $articles->total() }} Artikel</span>
                        </div>
                        <div class="bg-white/10 rounded-full px-4 py-2">
                            <span class="text-sm font-semibold">Bergabung {{ $author->created_at->translatedFormat('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 -mt-8 md:-mt-12 lg:-mt-16 relative z-10">
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Artikel oleh {{ $author->name }}</h2>
                    <p class="text-slate-600 mt-1">{{ $articles->total() }} artikel ditemukan</p>
                </div>
                <a href="{{ route('news') }}" class="text-sm font-semibold text-nu-600 hover:text-nu-700">← Kembali ke Berita</a>
            </div>

            @if($articles->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <article class="bg-slate-50 rounded-2xl overflow-hidden hover:shadow-lg transition border border-slate-100">
                            @if($article->cover_image)
                                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-40 w-full object-cover">
                            @else
                                <div class="h-40 w-full bg-gradient-to-br from-nu-100 to-nu-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-nu-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="font-semibold text-nu-600">{{ $article->category->name ?? 'Berita' }}</span>
                                    <span>{{ optional($article->published_at)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 line-clamp-2">{{ $article->title }}</h3>
                                <p class="text-sm text-slate-600 line-clamp-3">{{ Str::limit($article->excerpt, 120) }}</p>
                                <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm hover:text-nu-700">Baca Selengkapnya →</a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $articles->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Artikel</h3>
                    <p class="text-slate-600">{{ $author->name }} belum menulis artikel apapun.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
