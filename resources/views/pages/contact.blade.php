@extends('layouts.app')

@section('title', 'Kontak & Kolaborasi - Lazisnu Balongbendo')
@section('meta_description', 'Hubungi tim Lazisnu MWC NU Balongbendo untuk kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin. Sekretariat di Jl. KH. Hasyim Asyari No. 12, Balongbendo.')
@section('meta_keywords', 'kontak Lazisnu, alamat Lazisnu Balongbendo, telepon NU Balongbendo, kolaborasi program, sekretariat MWC NU')

@section('og_title', 'Kontak & Kolaborasi - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Hubungi tim Lazisnu MWC NU Balongbendo untuk kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.')
@section('og_url', route('contact'))
@section('og_type', 'website')

@section('twitter_title', 'Kontak & Kolaborasi - Lazisnu MWC NU Balongbendo')
@section('twitter_description', 'Hubungi tim Lazisnu MWC NU Balongbendo untuk kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-4xl mx-auto px-6 py-12 md:py-16 lg:py-20 text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">{{ $contact->header_subtitle }}</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">{{ $contact->header_title }}</h1>
            <p class="text-nu-100 mt-4">{{ $contact->header_description }}</p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-6 -mt-8 md:-mt-12 lg:-mt-16 relative grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8 space-y-4">
            <h2 class="text-2xl font-bold text-slate-900">{{ $contact->office_title }}</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                {!! nl2br(e($contact->office_address)) !!}<br>
                Jam layanan: {{ $contact->office_hours }}
            </p>
            <ul class="space-y-3 text-sm text-slate-600">
                <li><span class="font-semibold">Call Center:</span> {{ $contact->getFormattedPhone() }}</li>
                <li><span class="font-semibold">Email:</span> {{ $contact->email }}</li>
                <li><span class="font-semibold">Instagram:</span> {{ $contact->instagram }}</li>
                <li><span class="font-semibold">Facebook:</span> {{ $contact->facebook }}</li>
            </ul>
            <a href="{{ $contact->getWhatsAppUrl() }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-nu-600 text-white font-semibold hover:bg-nu-700">{{ $contact->whatsapp_text }}</a>
        </div>
        @if($contact->show_map && $contact->map_embed_url)
            <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden">
                <iframe
                    src="{{ $contact->map_embed_url }}"
                    width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        @elseif($contact->show_map)
            <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8 flex items-center justify-center h-[420px]">
                <div class="text-center text-slate-500">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-lg font-semibold">Peta Lokasi</p>
                    <p class="text-sm">URL embed peta belum dikonfigurasi</p>
                </div>
            </div>
        @endif
    </section>

    @if($contact->form_enabled)
        <section class="max-w-4xl mx-auto px-6 mt-16 text-center">
            <div class="bg-white rounded-[32px] shadow-lg border border-slate-100 p-8">
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">{{ $contact->form_subtitle }}</p>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">{{ $contact->form_title }}</h2>
                <p class="text-sm text-slate-500 mt-2">{{ $contact->form_description }}</p>
                @if($contact->form_action_url)
                    <form action="{{ $contact->form_action_url }}" method="POST" class="mt-6 grid gap-4">
                        <input type="text" name="name" placeholder="Nama lengkap" required class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                        <input type="email" name="_replyto" placeholder="Email aktif" required class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                        <textarea name="message" rows="4" placeholder="Tuliskan kebutuhan kolaborasi / publikasi" required class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"></textarea>
                        <button class="bg-nu-600 text-white font-semibold py-3 rounded-2xl hover:bg-nu-700">Kirim</button>
                    </form>
                @else
                    <div class="mt-6 p-6 bg-slate-50 rounded-2xl text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-slate-600">Formulir kontak belum dikonfigurasi</p>
                        <p class="text-sm text-slate-500 mt-1">Silakan hubungi kami melalui WhatsApp atau email</p>
                    </div>
                @endif
            </div>
        </section>
    @endif
@endsection

