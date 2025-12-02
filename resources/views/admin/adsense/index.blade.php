@extends('layouts.admin')

@section('title', 'Google AdSense - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Google AdSense</h1>
            <p class="text-gray-600 mt-1">Kelola iklan Google AdSense untuk monetisasi website</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 border border-red-200 rounded-xl bg-red-50 text-red-600 text-sm">
                <p class="font-semibold">Periksa kembali:</p>
                <ul class="list-disc list-inside mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.adsense.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- General Settings -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Umum</h3>
                
                <div class="space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="adsense_enabled" value="1" id="adsense_enabled" class="rounded text-blue-600 focus:ring-blue-600" {{ old('adsense_enabled', $settings->get('adsense_enabled')?->value) ? 'checked' : '' }}>
                        <label for="adsense_enabled" class="ml-2 text-sm font-semibold text-gray-700">Aktifkan Google AdSense</label>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Client ID AdSense</label>
                        <input type="text" name="adsense_client_id" value="{{ old('adsense_client_id', $settings->get('adsense_client_id')?->value) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="ca-pub-1234567890123456">
                        <p class="text-xs text-gray-500 mt-1">Contoh: ca-pub-1234567890123456</p>
                    </div>
                </div>
            </div>

            <!-- Ad Placements -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Penempatan Iklan</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Iklan Header</label>
                        <textarea name="adsense_header_ad" rows="4" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste kode iklan AdSense untuk header">{{ old('adsense_header_ad', $settings->get('adsense_header_ad')?->value) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Iklan yang akan ditampilkan di bagian atas halaman</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Iklan Sidebar</label>
                        <textarea name="adsense_sidebar_ad" rows="4" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste kode iklan AdSense untuk sidebar">{{ old('adsense_sidebar_ad', $settings->get('adsense_sidebar_ad')?->value) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Iklan yang akan ditampilkan di sidebar halaman</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Iklan Dalam Artikel</label>
                        <textarea name="adsense_article_ad" rows="4" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste kode iklan AdSense untuk dalam artikel">{{ old('adsense_article_ad', $settings->get('adsense_article_ad')?->value) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Iklan yang akan ditampilkan di tengah artikel</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Iklan Footer</label>
                        <textarea name="adsense_footer_ad" rows="4" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste kode iklan AdSense untuk footer">{{ old('adsense_footer_ad', $settings->get('adsense_footer_ad')?->value) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Iklan yang akan ditampilkan di bagian bawah halaman</p>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 rounded-xl p-6">
                <h4 class="text-sm font-semibold text-blue-900 mb-3">📋 Cara Menggunakan:</h4>
                <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                    <li>Daftar akun Google AdSense di <a href="https://www.google.com/adsense/" target="_blank" class="underline">google.com/adsense</a></li>
                    <li>Buat unit iklan baru di dashboard AdSense</li>
                    <li>Copy kode HTML yang diberikan</li>
                    <li>Paste kode tersebut ke form di atas sesuai posisi yang diinginkan</li>
                    <li>Aktifkan AdSense dan simpan pengaturan</li>
                </ol>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl">
                    Simpan Pengaturan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection






