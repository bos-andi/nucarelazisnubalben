@extends('layouts.app')

@section('title', 'Program Lazisnu Balongbendo')
@section('meta_description', 'Program strategis Lazisnu MWC NU Balongbendo. Fokus impact pemberdayaan ekonomi, kesehatan, pendidikan, lingkungan, dan respon bencana untuk kemandirian umat.')
@section('meta_keywords', 'program Lazisnu, sedekah produktif, respon bencana, beasiswa santri, ekonomi hijau, program sosial NU, pemberdayaan umat')

@section('og_title', 'Program Strategis - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Program strategis Lazisnu MWC NU Balongbendo. Fokus impact pemberdayaan ekonomi, kesehatan, pendidikan, lingkungan, dan respon bencana untuk kemandirian umat.')
@section('og_url', route('programs'))
@section('og_type', 'website')

@section('twitter_title', 'Program Strategis - Lazisnu MWC NU Balongbendo')
@section('twitter_description', 'Program strategis Lazisnu MWC NU Balongbendo. Fokus impact pemberdayaan ekonomi, kesehatan, pendidikan, lingkungan, dan respon bencana untuk kemandirian umat.')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Program Hijau</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">Fokus Impact Lazisnu Balongbendo</h1>
            <p class="text-nu-100 mt-4 max-w-3xl">Inisiatif pemberdayaan yang menggabungkan dakwah, sosial, kesehatan, pendidikan, ekonomi, hingga respon bencana dengan semangat kemandirian dan hijau.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 -mt-12 relative grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <div class="text-4xl mb-4">🌱</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Sedekah Produktif</h3>
            <p class="text-sm text-slate-600">Pemberdayaan UMKM hijau dengan modal bergulir dan pendampingan branding.</p>
        </div>
        
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <div class="text-4xl mb-4">🤝</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Respon Cepat Bencana</h3>
            <p class="text-sm text-slate-600">Gerak cepat relawan NU Peduli membawa logistik dan layanan kesehatan.</p>
        </div>
        
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <div class="text-4xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Beasiswa Santri</h3>
            <p class="text-sm text-slate-600">Investasi pendidikan dengan pelatihan wirausaha digital bagi santri kreatif.</p>
        </div>
    </section>

    <!-- Kategori Program -->
    <section class="max-w-6xl mx-auto px-6 mt-16">
        <div class="text-center mb-12">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Bidang Program</p>
            <h2 class="text-3xl font-bold text-slate-900 mt-2">Area Fokus Pemberdayaan</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
            @foreach ($categories as $category)
                <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-8 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="h-10 w-10 rounded-2xl" style="background: {{ $category->color ?? '#dcfce7' }}"></span>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h2>
                    </div>
                    <p class="text-sm text-slate-600">{{ $category->description ?? 'Fokus program Lazisnu MWC NU Balongbendo.' }}</p>
                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="inline-flex items-center text-nu-600 font-semibold text-sm">Lihat berita kategori ini →</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Pendukung Program -->
    <section class="max-w-6xl mx-auto px-6 mt-16 grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Pendanaan</p>
            <h3 class="text-xl font-semibold mt-2">Skema ZIS Ramah Digital</h3>
            <p class="text-sm text-slate-600 mt-2">Integrasi QRIS, transfer bank, dan jemput zakat untuk memudahkan muzakki menunaikan kewajibannya.</p>
        </div>
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Kemitraan</p>
            <h3 class="text-xl font-semibold mt-2">Sinergi Ranting &amp; Banom</h3>
            <p class="text-sm text-slate-600 mt-2">Program dihidupkan bersama GP Ansor, Fatayat, Muslimat, IPNU-IPPNU, dan jejaring komunitas hijau.</p>
        </div>
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Transparansi</p>
            <h3 class="text-xl font-semibold mt-2">Laporan Impact</h3>
            <p class="text-sm text-slate-600 mt-2">Setiap triwulan, Lazisnu menerbitkan laporan publik berisi capaian program, jumlah mustahik, dan testimoni.</p>
        </div>
    </section>
@endsection

