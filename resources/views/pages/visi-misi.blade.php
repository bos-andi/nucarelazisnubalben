@extends('layouts.app')

@section('title', 'Visi Misi - Lazisnu Balongbendo')
@section('meta_description', 'Visi dan Misi Lazisnu MWC NU Balongbendo. Komitmen dalam membangun kemandirian ekonomi umat dan kesejahteraan masyarakat melalui nilai-nilai amanah, transparan, dan profesional.')
@section('meta_keywords', 'visi misi Lazisnu, visi NU Balongbendo, misi Lazisnu, nilai organisasi NU, amanah transparan profesional')

@section('og_title', 'Visi & Misi - Lazisnu MWC NU Balongbendo')
@section('og_description', 'Visi dan Misi Lazisnu MWC NU Balongbendo. Komitmen dalam membangun kemandirian ekonomi umat dan kesejahteraan masyarakat melalui nilai-nilai amanah, transparan, dan profesional.')
@section('og_url', route('visi-misi'))
@section('og_type', 'website')

@section('twitter_title', 'Visi & Misi - Lazisnu MWC NU Balongbendo')
@section('twitter_description', 'Visi dan Misi Lazisnu MWC NU Balongbendo. Komitmen dalam membangun kemandirian ekonomi umat dan kesejahteraan masyarakat melalui nilai-nilai amanah, transparan, dan profesional.')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-4xl mx-auto px-6 py-12 md:py-16 lg:py-20 text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Visi & Misi</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">Lazisnu MWC NU Balongbendo</h1>
            <p class="text-nu-100 mt-4">Komitmen kami dalam membangun kemandirian ekonomi umat dan kesejahteraan masyarakat</p>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 -mt-8 md:-mt-12 lg:-mt-16 relative z-10">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Visi -->
            <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-nu-500 to-nu-700 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Visi</h2>
                </div>
                <p class="text-slate-600 leading-relaxed">{{ $visionMission->vision }}</p>
            </div>

            <!-- Misi -->
            <div class="bg-white rounded-[32px] shadow-2xl border border-slate-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-nu-500 to-nu-700 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Misi</h2>
                </div>
                <div class="text-slate-600 leading-relaxed">
                    {!! nl2br(e($visionMission->mission)) !!}
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai-nilai Organisasi -->
    <section class="max-w-6xl mx-auto px-6 mt-16">
        <div class="text-center mb-12">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Nilai Organisasi</p>
            <h2 class="text-3xl font-bold text-slate-900 mt-2">Prinsip Kerja Lazisnu</h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-nu-500 to-nu-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Amanah</h3>
                <p class="text-slate-600">Mengelola dana sosial dengan penuh tanggung jawab dan kepercayaan</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-nu-500 to-nu-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Transparan</h3>
                <p class="text-slate-600">Keterbukaan dalam pelaporan dan pertanggungjawaban program</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-nu-500 to-nu-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Profesional</h3>
                <p class="text-slate-600">Bekerja dengan standar tinggi dan kompetensi yang mumpuni</p>
            </div>
        </div>
    </section>
@endsection
