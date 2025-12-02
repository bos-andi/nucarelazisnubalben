@extends('layouts.app')

@section('title', 'Khutbah Jum\'at - Lazisnu Balongbendo')
@section('meta_description', 'Kumpulan khutbah Jum\'at Lazisnu MWC NU Balongbendo dengan konten bahasa Arab dan terjemahan bahasa Indonesia.')
@section('meta_keywords', 'khutbah jumat, khutbah NU, khutbah bahasa arab, terjemahan khutbah, Lazisnu Balongbendo')

@section('og_title', 'Khutbah Jum\'at - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Kumpulan khutbah Jum\'at Lazisnu MWC NU Balongbendo dengan konten bahasa Arab dan terjemahan bahasa Indonesia.')
@section('og_url', route('khutbah'))
@section('og_type', 'website')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-6xl mx-auto px-6 py-16 pb-24">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Khutbah Jum'at</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">Khutbah Jum'at</h1>
            <p class="text-nu-100 mt-4 max-w-3xl leading-relaxed">Kumpulan khutbah Jum'at dengan konten bahasa Arab dan terjemahan bahasa Indonesia.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 -mt-12 relative z-10">
        <div class="bg-white rounded-[32px] shadow-2xl p-8">
            <form action="{{ route('khutbah') }}" method="GET" class="flex gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari khutbah..." 
                       class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nu-500 focus:border-transparent">
                <button type="submit" class="bg-nu-600 text-white px-6 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 mt-12 mb-20">
        @if($khutbahs->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($khutbahs as $khutbah)
                    <article class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-100 hover:-translate-y-1 transition">
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $khutbah->khutbah_date->translatedFormat('d M Y') }}</span>
                                @if($khutbah->khatib)
                                    <span>{{ $khutbah->khatib }}</span>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-slate-900 line-clamp-2">{{ $khutbah->title }}</h3>
                            @if($khutbah->location)
                                <p class="text-sm text-slate-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $khutbah->location }}
                                </p>
                            @endif
                            <div class="pt-4 border-t border-slate-100">
                                <a href="{{ route('khutbah.show', $khutbah) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm hover:text-nu-700">
                                    Baca Khutbah
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $khutbahs->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <p class="mt-4 text-slate-500 text-lg">Belum ada khutbah yang tersedia</p>
            </div>
        @endif
    </section>
@endsection




