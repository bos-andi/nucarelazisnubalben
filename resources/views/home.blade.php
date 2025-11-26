@extends('layouts.app')

@section('title', 'Portal Berita Lazisnu Balongbendo')
@section('meta_description', 'Website resmi Lazisnu MWC NU Balongbendo. Portal berita, program sosial, galeri kegiatan, dan informasi zakat, infak, sedekah untuk warga Balongbendo dan sekitarnya.')
@section('meta_keywords', 'Lazisnu Balongbendo, NU Balongbendo, zakat Balongbendo, infak sedekah, program sosial NU, berita NU, MWC NU Balongbendo')

@section('og_title', 'Lazisnu MWC NU Balongbendo - Portal Berita & Program Sosial')
@section('og_description', 'Website resmi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')
@section('og_url', route('home'))
@section('og_type', 'website')

@section('twitter_title', 'Lazisnu MWC NU Balongbendo - Portal Berita & Program Sosial')
@section('twitter_description', 'Website resmi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top,_#ffffff33,_transparent_50%)]"></div>
        <div class="relative max-w-6xl mx-auto px-6 py-14 md:py-20 grid gap-10 md:grid-cols-2 items-center">
            <div>
                <p class="uppercase tracking-[0.4em] text-xs text-nu-200 font-semibold">Lazisnu Balongbendo</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mt-4">{{ \App\Models\SiteSetting::get('hero_title', 'Kabar Kebaikan & Aksi Hijau Dari Bumi Balongbendo') }}</h1>
                <p class="text-nu-100 mt-6 text-lg leading-relaxed">{{ \App\Models\SiteSetting::get('hero_description', 'Menguatkan gerakan zakat, infak, sedekah, dan program sosial untuk menghadirkan kemandirian ekonomi umat.') }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('news') }}" class="bg-white text-nu-700 font-semibold px-6 py-3 rounded-full shadow-lg shadow-white/30 hover:-translate-y-0.5 transition">Lihat Berita</a>
                    <a href="{{ route('programs') }}" class="border border-white/60 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/10">Program Unggulan</a>
                </div>
                <dl class="mt-10 grid grid-cols-3 gap-6 text-center">
                    <div class="p-4 bg-white/10 rounded-2xl">
                        <dt class="text-sm text-nu-100">Desa Dampingan</dt>
                        <dd class="text-2xl font-bold">23</dd>
                    </div>
                    <div class="p-4 bg-white/10 rounded-2xl">
                        <dt class="text-sm text-nu-100">Relawan Aktif</dt>
                        <dd class="text-2xl font-bold">120+</dd>
                    </div>
                    <div class="p-4 bg-white/10 rounded-2xl">
                        <dt class="text-sm text-nu-100">Program</dt>
                        <dd class="text-2xl font-bold">48</dd>
                    </div>
                </dl>
            </div>
            @if ($featured)
                <article class="glass rounded-[32px] shadow-2xl overflow-hidden border border-white/40">
                    <img src="{{ $featured->cover_image }}" alt="{{ $featured->title }}" class="h-64 w-full object-cover">
                    <div class="p-8 space-y-4">
                        <span class="inline-flex px-4 py-1 text-xs font-semibold rounded-full bg-nu-100 text-nu-700">{{ $featured->category->name ?? 'Berita' }}</span>
                        <h2 class="text-2xl font-bold text-nu-900">{{ $featured->title }}</h2>
                        <p class="text-slate-600">{{ $featured->excerpt }}</p>
                        <div class="flex justify-between items-center text-sm text-slate-500">
                            <span>Oleh {{ $featured->author ?? 'Tim Lazisnu' }}</span>
                            <span>{{ optional($featured->published_at)->translatedFormat('d M Y') }}</span>
                        </div>
                        <a href="{{ route('articles.show', $featured) }}" class="inline-flex items-center gap-2 text-nu-600 font-semibold">
                            Baca kisah penuh
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @endif
        </div>
    </section>

    <section id="berita" class="max-w-6xl mx-auto px-6 mt-16">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Update Terkini</p>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Berita Terbaru</h2>
            </div>
            <a href="{{ route('news') }}" class="text-sm font-semibold text-nu-600 hover:text-nu-700">Lihat Semua Berita →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-8 mt-10">
            @forelse ($latest as $article)
                <article class="bg-white rounded-3xl overflow-hidden shadow-lg hover:-translate-y-1 transition border border-slate-100">
                    <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-48 w-full object-cover">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="font-semibold text-nu-600">{{ $article->category->name ?? 'Berita' }}</span>
                            <span>{{ optional($article->published_at)->translatedFormat('d M Y') }}</span>
                        </div>
                        @if($article->user)
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                @if($article->user->avatar)
                                    <img src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}" class="w-4 h-4 rounded-full object-cover">
                                @else
                                    <div class="w-4 h-4 rounded-full bg-nu-100 flex items-center justify-center text-xs font-semibold text-nu-600">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span>Oleh <a href="{{ route('author.profile', $article->user->id) }}" class="text-nu-600 hover:text-nu-700 font-medium">{{ $article->user->name }}</a></span>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-slate-900">{{ $article->title }}</h3>
                        <p class="text-sm text-slate-600">{{ Str::limit($article->excerpt, 140) }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm">Selengkapnya →</a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center text-slate-500 py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                    Belum ada berita. Silakan tambahkan melalui panel Kelola Berita.
                </div>
            @endforelse
        </div>
    </section>

    @if(isset($gallery) && $gallery->count())
        <section class="max-w-6xl mx-auto px-6 mt-20">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dokumentasi</p>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">Galeri Lazisnu</h2>
                </div>
                <a href="{{ route('gallery') }}" class="text-sm font-semibold text-nu-600 hover:text-nu-700 hidden md:inline-flex">Lihat semua →</a>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mt-8">
                @foreach ($gallery as $item)
                    <div class="rounded-3xl bg-white overflow-hidden shadow-lg border border-slate-100">
                        <div class="relative">
                            <img src="{{ $item->thumbnail_url ?? $item->media_url }}" alt="{{ $item->title }}" class="h-48 w-full object-cover">
                            @if($item->type === 'video')
                                <span class="absolute top-3 left-3 bg-black/70 text-white text-xs px-3 py-1 rounded-full">Video</span>
                            @endif
                        </div>
                        <div class="p-5 space-y-2">
                            <p class="text-xs uppercase tracking-[0.3em] text-nu-500">{{ $item->platform ?? Str::upper($item->type) }}</p>
                            <h3 class="font-semibold text-lg">{{ $item->title }}</h3>
                            <p class="text-sm text-slate-500">{{ Str::limit($item->description, 110) }}</p>
                            <a href="{{ $item->media_url }}" target="_blank" class="inline-flex items-center text-nu-600 font-semibold text-sm">Buka media →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="max-w-6xl mx-auto px-6 mt-20">
        <div class="rounded-[32px] bg-gradient-to-r from-nu-600 to-nu-500 text-white p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.4em] text-nu-200 font-semibold">Kolaborasi</p>
                <h2 class="text-3xl font-bold mt-2">Ingin bergabung jadi relawan atau donatur tetap?</h2>
                <p class="text-nu-50 mt-4">Hubungi tim kami untuk mendapatkan proposal program dan laporan transparansi penyaluran.</p>
            </div>
            <a href="https://wa.me/6281312345678" target="_blank" class="bg-white text-nu-700 font-semibold px-8 py-4 rounded-full shadow-lg shadow-nu-900/30 text-center">Hubungi Sekarang</a>
        </div>
    </section>
@endsection

