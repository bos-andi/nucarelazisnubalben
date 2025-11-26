@extends('layouts.admin')

@section('title', 'Kelola Kontak')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Kelola Halaman Kontak</h1>
            <p class="text-slate-600">Kelola informasi kontak dan formulir pada halaman kontak</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.contact.update') }}" method="POST" class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Header Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 bg-nu-500 rounded-full p-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Header Section</h2>
                        <p class="text-slate-600">Kelola bagian header halaman kontak</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="header_subtitle" class="block text-sm font-semibold text-slate-600 mb-2">Subtitle Header*</label>
                        <input type="text" name="header_subtitle" id="header_subtitle" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('header_subtitle', $contact->header_subtitle) }}" required>
                        @error('header_subtitle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="header_title" class="block text-sm font-semibold text-slate-600 mb-2">Judul Header*</label>
                        <input type="text" name="header_title" id="header_title" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('header_title', $contact->header_title) }}" required>
                        @error('header_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="header_description" class="block text-sm font-semibold text-slate-600 mb-2">Deskripsi Header*</label>
                    <textarea name="header_description" id="header_description" rows="3" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('header_description', $contact->header_description) }}</textarea>
                    @error('header_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Contact Info Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 bg-nu-500 rounded-full p-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Informasi Kontak</h2>
                        <p class="text-slate-600">Kelola informasi sekretariat dan kontak</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="office_title" class="block text-sm font-semibold text-slate-600 mb-2">Judul Kantor*</label>
                        <input type="text" name="office_title" id="office_title" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('office_title', $contact->office_title) }}" required>
                        @error('office_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="office_hours" class="block text-sm font-semibold text-slate-600 mb-2">Jam Operasional*</label>
                        <input type="text" name="office_hours" id="office_hours" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('office_hours', $contact->office_hours) }}" required>
                        @error('office_hours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="office_address" class="block text-sm font-semibold text-slate-600 mb-2">Alamat Kantor*</label>
                    <textarea name="office_address" id="office_address" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('office_address', $contact->office_address) }}</textarea>
                    @error('office_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-600 mb-2">Nomor Telepon*</label>
                        <input type="text" name="phone" id="phone" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('phone', $contact->phone) }}" required>
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-600 mb-2">Email*</label>
                        <input type="email" name="email" id="email" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('email', $contact->email) }}" required>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="instagram" class="block text-sm font-semibold text-slate-600 mb-2">Instagram*</label>
                        <input type="text" name="instagram" id="instagram" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('instagram', $contact->instagram) }}" required>
                        @error('instagram')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="facebook" class="block text-sm font-semibold text-slate-600 mb-2">Facebook*</label>
                        <input type="text" name="facebook" id="facebook" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('facebook', $contact->facebook) }}" required>
                        @error('facebook')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-semibold text-slate-600 mb-2">Nomor WhatsApp*</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('whatsapp_number', $contact->whatsapp_number) }}" required>
                        <p class="text-xs text-slate-400 mt-1">Format: 6281234567890 (dengan kode negara)</p>
                        @error('whatsapp_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="whatsapp_text" class="block text-sm font-semibold text-slate-600 mb-2">Teks Tombol WhatsApp*</label>
                        <input type="text" name="whatsapp_text" id="whatsapp_text" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('whatsapp_text', $contact->whatsapp_text) }}" required>
                        @error('whatsapp_text')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Map Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 bg-nu-500 rounded-full p-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Peta Lokasi</h2>
                        <p class="text-slate-600">Kelola embed peta Google Maps</p>
                    </div>
                </div>

                <div>
                    <label for="map_embed_url" class="block text-sm font-semibold text-slate-600 mb-2">URL Embed Google Maps</label>
                    <input type="url" name="map_embed_url" id="map_embed_url" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('map_embed_url', $contact->map_embed_url) }}">
                    <p class="text-xs text-slate-400 mt-1">Dapatkan dari Google Maps → Share → Embed a map → Copy HTML → Ambil URL dari src=""</p>
                    @error('map_embed_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="show_map" id="show_map" value="1" {{ old('show_map', $contact->show_map) ? 'checked' : '' }} class="rounded border-slate-300 text-nu-600 shadow-sm focus:ring-nu-500">
                    <label for="show_map" class="ml-2 block text-sm text-slate-900">Tampilkan peta</label>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Form Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 bg-nu-500 rounded-full p-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Formulir Kontak</h2>
                        <p class="text-slate-600">Kelola formulir kontak pengunjung</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="form_subtitle" class="block text-sm font-semibold text-slate-600 mb-2">Subtitle Form*</label>
                        <input type="text" name="form_subtitle" id="form_subtitle" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('form_subtitle', $contact->form_subtitle) }}" required>
                        @error('form_subtitle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="form_title" class="block text-sm font-semibold text-slate-600 mb-2">Judul Form*</label>
                        <input type="text" name="form_title" id="form_title" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('form_title', $contact->form_title) }}" required>
                        @error('form_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="form_description" class="block text-sm font-semibold text-slate-600 mb-2">Deskripsi Form*</label>
                    <textarea name="form_description" id="form_description" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('form_description', $contact->form_description) }}</textarea>
                    @error('form_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="form_action_url" class="block text-sm font-semibold text-slate-600 mb-2">URL Action Form</label>
                    <input type="url" name="form_action_url" id="form_action_url" class="w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" value="{{ old('form_action_url', $contact->form_action_url) }}">
                    <p class="text-xs text-slate-400 mt-1">Contoh: https://formspree.io/f/xknlqqre (untuk layanan form eksternal)</p>
                    @error('form_action_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="form_enabled" id="form_enabled" value="1" {{ old('form_enabled', $contact->form_enabled) ? 'checked' : '' }} class="rounded border-slate-300 text-nu-600 shadow-sm focus:ring-nu-500">
                    <label for="form_enabled" class="ml-2 block text-sm text-slate-900">Aktifkan formulir kontak</label>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- General Settings -->
            <div class="space-y-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $contact->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-nu-600 shadow-sm focus:ring-nu-500">
                    <label for="is_active" class="ml-2 block text-sm text-slate-900">Aktifkan halaman kontak</label>
                </div>

                <button type="submit" class="px-6 py-3 bg-nu-600 text-white font-semibold rounded-xl hover:bg-nu-700 transition-colors">
                    Simpan Pengaturan Kontak
                </button>
            </div>
        </form>
    </div>
@endsection
