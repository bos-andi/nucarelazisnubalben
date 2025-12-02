@extends('layouts.admin')

@section('title', 'Profil Saya - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-600 mt-1">Kelola informasi akun dan keamanan Anda</p>
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

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Profile Info -->
            <div class="lg:col-span-2">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-6 card-shadow">
                    @csrf
                    @method('PUT')
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Profil</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-600">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-600">Foto Profil</label>
                            <input type="file" name="avatar" accept="image/*" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Upload gambar (max 2MB). Akan otomatis di-resize menjadi 200x200px.</p>
                        </div>
                    </div>

                    <hr class="my-8">

                    @if($user->isContributor())
                        <!-- KTP Verification Section -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Verifikasi KTP</h3>
                        
                        @if($user->is_ktp_verified)
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm font-semibold text-green-800">KTP Anda sudah terverifikasi</p>
                                </div>
                                @if($user->ktp_file)
                                    <a href="{{ $user->ktp_file }}" target="_blank" class="text-sm text-green-700 hover:text-green-800 underline">
                                        Lihat KTP yang sudah diupload
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <p class="text-sm text-yellow-800 mb-4">
                                    <strong>Upload KTP Anda</strong> untuk mendapatkan badge verifikasi biru. KTP akan diverifikasi oleh superadmin.
                                </p>
                                
                                <div>
                                    <label class="text-sm font-semibold text-gray-600">Upload KTP</label>
                                    <input type="file" name="ktp_file" accept="image/*,.pdf" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF (max 5MB)</p>
                                </div>
                                
                                @if($user->ktp_file)
                                    <div class="mt-4 p-3 bg-white rounded-lg border border-yellow-300">
                                        <p class="text-xs text-gray-600 mb-2">KTP yang sudah diupload (menunggu verifikasi):</p>
                                        <a href="{{ $user->ktp_file }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline">
                                            Lihat KTP
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif

                    <hr class="my-8">

                    <h3 id="password" class="text-lg font-semibold text-gray-900 mb-6">Ubah Password</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Password Saat Ini</label>
                            <input type="password" name="current_password" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-600">Password Baru</label>
                            <input type="password" name="password" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-600">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Profile Card -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl p-6 card-shadow text-center">
                    <div class="mb-4">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-gray-100">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h4 class="font-semibold text-gray-900 mb-4">Statistik Saya</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Berita Ditulis</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->articles()->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Bergabung Sejak</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Terakhir Login</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


