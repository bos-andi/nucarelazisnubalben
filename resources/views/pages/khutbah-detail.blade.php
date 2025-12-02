@extends('layouts.app')

@section('title', $khutbah->title . ' - Khutbah Jum\'at Lazisnu Balongbendo')
@section('meta_description', Str::limit(strip_tags($khutbah->content), 160))
@section('meta_keywords', 'khutbah jumat, ' . $khutbah->title . ', Lazisnu, NU, Balongbendo')

@section('og_title', $khutbah->title)
@section('og_description', Str::limit(strip_tags($khutbah->content), 200))
@section('og_url', route('khutbah.show', $khutbah))
@section('og_type', 'article')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
<style>
    .prose .arabic-content {
        font-family: 'Amiri', 'Noto Sans Arabic', 'Arial', sans-serif;
        font-size: 20px;
        line-height: 2.5;
        direction: rtl;
        text-align: right;
        margin-bottom: 2rem;
    }
    .prose .indonesian-content {
        margin-top: 2rem;
    }
    .prose img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-4xl mx-auto px-6 py-16">
            <a href="{{ route('khutbah') }}" class="inline-flex items-center text-nu-100 hover:text-white mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Khutbah
            </a>
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Khutbah Jum'at</p>
            <h1 class="text-3xl md:text-4xl font-bold mt-4">{{ $khutbah->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 mt-6 text-sm text-nu-100">
                <span>{{ $khutbah->khutbah_date->translatedFormat('l, d F Y') }}</span>
                @if($khutbah->khatib)
                    <span>•</span>
                    <span>Khatib: {{ $khutbah->khatib }}</span>
                @endif
                @if($khutbah->location)
                    <span>•</span>
                    <span>{{ $khutbah->location }}</span>
                @endif
            </div>
        </div>
    </section>

    <article class="max-w-4xl mx-auto px-6 -mt-12 relative z-10 mb-20">
        <div class="bg-white rounded-[32px] shadow-2xl overflow-hidden">
            <!-- Content -->
            <div class="p-8 md:p-12">
                <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                    {!! $khutbah->content !!}
                </div>
            </div>
        </div>

        <!-- Related Khutbahs -->
        @if($related->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Khutbah Lainnya</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach ($related as $relatedKhutbah)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:-translate-y-1 transition">
                            <div class="p-6 space-y-3">
                                <div class="text-xs text-slate-500">
                                    {{ $relatedKhutbah->khutbah_date->translatedFormat('d M Y') }}
                                </div>
                                <h4 class="text-lg font-semibold text-slate-900 line-clamp-2">{{ $relatedKhutbah->title }}</h4>
                                <a href="{{ route('khutbah.show', $relatedKhutbah) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm hover:text-nu-700">
                                    Baca Khutbah
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection

