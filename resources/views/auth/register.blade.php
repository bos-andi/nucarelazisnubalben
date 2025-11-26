@extends('layouts.app')

@section('title', 'Daftar Kontributor - Lazisnu Balongbendo')

@section('content')
    <section class="max-w-xl mx-auto px-6 py-16">
        <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-8">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Kontributor</p>
            <h1 class="text-3xl font-bold text-slate-900 mt-2">Daftar Akun Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Setelah masuk, Anda dapat menulis berita komunitas.</p>

            @if ($errors->any())
                <div class="mt-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-600 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Password</label>
                    <input type="password" name="password" required minlength="6"
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required minlength="6"
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <button type="submit" class="w-full bg-nu-600 text-white font-semibold py-3 rounded-2xl hover:bg-nu-700">
                    Buat Akun
                </button>
            </form>

            <p class="text-sm text-center text-slate-500 mt-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-nu-600 font-semibold">Masuk</a>
            </p>
        </div>
    </section>
@endsection

