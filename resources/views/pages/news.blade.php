@extends('layouts.app')

@section('title', 'Berita Lazisnu Balongbendo')
@section('meta_description', 'Berita terkini Lazisnu MWC NU Balongbendo. Rangkuman kegiatan, program sosial, hingga respon cepat untuk jamaah Nahdliyin di Balongbendo dan sekitarnya.')
@section('meta_keywords', 'berita Lazisnu, berita NU Balongbendo, kegiatan NU, program sosial, respon bencana, ekonomi hijau, pendidikan, kesehatan')

@section('og_title', 'Berita Terkini - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Berita terkini Lazisnu MWC NU Balongbendo. Rangkuman kegiatan, program sosial, hingga respon cepat untuk jamaah Nahdliyin di Balongbendo dan sekitarnya.')
@section('og_url', route('news'))
@section('og_type', 'website')

@section('twitter_title', 'Berita Terkini - Lazisnu MWC NU Balongbendo')
@section('twitter_description', 'Berita terkini Lazisnu MWC NU Balongbendo. Rangkuman kegiatan, program sosial, hingga respon cepat untuk jamaah Nahdliyin di Balongbendo dan sekitarnya.')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-6xl mx-auto px-6 py-16 pb-24">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Portal Berita</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">Berita Pilihan</h1>
            <p class="text-nu-100 mt-4 max-w-3xl leading-relaxed">Rangkuman kegiatan, program sosial, hingga respon cepat Lazisnu MWC NU Balongbendo untuk jamaah Nahdliyin.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 -mt-12 relative z-10">
        <div class="bg-white rounded-[32px] shadow-2xl p-8">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('news') }}" class="px-4 py-2 rounded-full border {{ request('category') ? 'border-slate-200 text-slate-500' : 'bg-nu-600 text-white border-nu-600' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full border {{ request('category') === $category->slug ? 'bg-nu-100 border-nu-200 text-nu-700' : 'border-slate-200 text-slate-600 hover:border-nu-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 mt-12">
        <div class="grid md:grid-cols-3 gap-8">
            @forelse ($articles as $article)
                <article class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-100 hover:-translate-y-1 transition">
                    @if ($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-48 w-full object-cover">
                    @else
                        <div class="h-48 w-full bg-gradient-to-r from-slate-100 to-slate-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill_rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip_rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                            <span class="font-semibold text-nu-600">{{ $article->category->name ?? 'Berita' }}</span>
                            <span>{{ optional($article->published_at)->translatedFormat('d M Y') }}</span>
                        </div>
                        @if($article->user)
                            <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                                @if($article->user->avatar)
                                    <img src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}" class="w-5 h-5 rounded-full object-cover">
                                @else
                                    <div class="w-5 h-5 rounded-full bg-nu-100 flex items-center justify-center text-xs font-semibold text-nu-600">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex items-center gap-1.5">
                                    <span>Oleh <a href="{{ route('author.profile', $article->user->id) }}" class="text-nu-600 hover:text-nu-700 font-medium">{{ $article->user->name }}</a></span>
                                    @if($article->user->isSuperAdmin())
                                        <!-- Superadmin Badge -->
                                        <svg class="h-3.5 w-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20" title="Superadmin">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($article->user->isContributor() && $article->user->hasVerifiedKtp())
                                        <!-- Verified Contributor Badge -->
                                        <svg class="h-3.5 w-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Kontributor Terverifikasi">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <h2 class="text-xl font-semibold text-slate-900 mb-3 leading-tight">{{ $article->title }}</h2>
                        <p class="text-sm text-slate-600 mb-4 leading-relaxed">{{ Str::limit($article->excerpt, 120) }}</p>
                        @if($article->tags->count() > 0)
                            <div class="flex gap-2 flex-wrap mb-4">
                                @foreach ($article->tags->take(2) as $tag)
                                    <span class="px-2 py-1 text-xs rounded-full bg-nu-50 text-nu-700 border border-nu-100">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm hover:text-nu-700 transition-colors">Baca detail →</a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center text-slate-500 py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                    Belum ada artikel.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    </section>
@endsection

