@extends('layouts.app')

@section('title', 'Lupa Password - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-nu-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white">Lupa Password?</h2>
            <p class="mt-2 text-nu-100">Masukkan email Anda untuk mendapatkan bantuan reset password</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if (session('status'))
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-blue-800 text-sm">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-800 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Kontributor</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-nu-500 focus:border-nu-500 transition-colors"
                           placeholder="masukkan@email.anda">
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-nu-600 hover:bg-nu-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kirim Permintaan Reset
                    </button>
                </div>
            </form>

            <!-- Help Information -->
            <div class="mt-8 p-4 bg-nu-50 border border-nu-200 rounded-xl">
                <h3 class="text-sm font-semibold text-nu-800 mb-2">📞 Butuh Bantuan Langsung?</h3>
                <div class="text-sm text-nu-700 space-y-2">
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/6281312345678" class="text-nu-600 hover:text-nu-800 underline">0813-1234-5678</a></p>
                    <p><strong>Email:</strong> <a href="mailto:admin@lazisnubalongbendo.or.id" class="text-nu-600 hover:text-nu-800 underline">admin@lazisnubalongbendo.or.id</a></p>
                    <p class="text-xs text-nu-600 mt-3">
                        💡 <strong>Tips:</strong> Sertakan nama lengkap dan email yang terdaftar saat menghubungi superadmin untuk mempercepat proses reset password.
                    </p>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-nu-600 hover:text-nu-800 text-sm font-medium transition-colors">
                    ← Kembali ke halaman login
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center text-nu-100 text-sm">
            <p>Sistem Admin Lazisnu MWC NU Balongbendo</p>
            <p class="text-xs text-nu-200 mt-1">Untuk keamanan, reset password hanya dapat dilakukan oleh superadmin</p>
        </div>
    </div>
</div>
@endsection
