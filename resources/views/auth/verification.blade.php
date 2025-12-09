<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Akun - Lazisnu Balongbendo</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nu: {
                            50: '#ecfdf3',
                            100: '#d1fadf',
                            200: '#a7f3c7',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        nuDark: '#1a1a2e',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <main class="flex-1">
<section class="max-w-3xl mx-auto px-6 py-16">
    <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100 mb-4">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Verifikasi Akun</p>
            <h1 class="text-3xl font-bold text-slate-900 mt-2">Lengkapi Data Verifikasi</h1>
            <p class="text-sm text-slate-500 mt-1">Isi data lengkap dan upload foto KTP untuk verifikasi akun</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 border border-red-200 rounded-2xl bg-red-50">
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 p-4 border border-green-200 rounded-2xl bg-green-50 text-green-800 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($user->verification_submitted_at)
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Data Sudah Dikirim</h3>
                        <p class="text-sm text-blue-800 mb-2">
                            Data verifikasi Anda sudah dikirim pada <strong>{{ $user->verification_submitted_at ? \Carbon\Carbon::parse($user->verification_submitted_at)->format('d M Y, H:i') : '' }}</strong>. 
                            Silakan tunggu persetujuan dari superadmin.
                        </p>
                        @if($user->ktp_file)
                            <p class="text-sm text-blue-800">
                                <strong>KTP:</strong> <a href="{{ $user->ktp_file }}" target="_blank" class="underline">Lihat KTP yang sudah diupload</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.verification.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Data Pribadi -->
            <div class="border border-slate-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">📋 Data Pribadi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}" 
                               required
                               placeholder="0812-3456-7890"
                               class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" 
                                required
                                class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="birth_place" 
                               value="{{ old('birth_place', $user->birth_place) }}" 
                               required
                               placeholder="Sidoarjo"
                               class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="birth_date" 
                               value="{{ old('birth_date', $user->birth_date) }}" 
                               required
                               max="{{ date('Y-m-d') }}"
                               class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Pekerjaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="occupation" 
                               value="{{ old('occupation', $user->occupation) }}" 
                               required
                               placeholder="Guru, Wiraswasta, dll"
                               class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-600 block mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" 
                                  required
                                  rows="3"
                                  placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota"
                                  class="w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Upload KTP -->
            <div class="border border-slate-200 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">🆔 Upload Foto KTP</h3>
                
                <div>
                    <label class="text-sm font-semibold text-slate-600 block mb-2">
                        Foto KTP <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="file" 
                               name="ktp_file" 
                               id="ktp_file"
                               accept="image/jpeg,image/png,image/jpg"
                               {{ !$user->ktp_file ? 'required' : '' }}
                               onchange="previewKTP(this)"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-nu-600 file:text-white hover:file:bg-nu-700">
                        <p class="mt-2 text-xs text-slate-500">
                            Format: JPG, PNG (Maksimal 5MB). Pastikan foto KTP jelas dan terbaca.
                            @if($user->ktp_file)
                                <span class="text-blue-600">(Opsional: Upload ulang jika ingin mengganti)</span>
                            @endif
                        </p>
                    </div>
                    
                    <!-- Preview KTP -->
                    <div id="ktp_preview" class="mt-4 hidden">
                        <img id="ktp_preview_img" src="" alt="Preview KTP" class="max-w-full h-auto rounded-2xl border border-slate-200">
                    </div>

                    @if($user->ktp_file && !$errors->has('ktp_file'))
                        <div class="mt-4">
                            <p class="text-sm text-slate-600 mb-2">KTP yang sudah diupload:</p>
                            <img src="{{ $user->ktp_file }}" alt="KTP" class="max-w-full h-auto rounded-2xl border border-slate-200">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-900 mb-2">Penting!</h3>
                        <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                            <li>Semua field yang bertanda <span class="text-red-500">*</span> wajib diisi</li>
                            <li>Foto KTP harus jelas dan terbaca</li>
                            <li>Data yang sudah dikirim akan ditinjau oleh superadmin</li>
                            <li>Anda akan mendapat notifikasi setelah akun disetujui</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-slate-200 text-slate-700 font-semibold py-3 rounded-2xl hover:bg-slate-300 transition-colors">
                        Keluar
                    </button>
                </form>
                <button type="submit" class="flex-1 bg-nu-600 text-white font-semibold py-3 rounded-2xl hover:bg-nu-700 transition-colors">
                    {{ $user->verification_submitted_at ? 'Update Data Verifikasi' : 'Kirim Data Verifikasi' }}
                </button>
            </div>
        </form>
    </div>
</section>
        </main>

        <!-- Footer Copyright Only -->
        <footer class="bg-nuDark text-white mt-auto">
            <div class="border-t border-white/10 text-center text-xs text-nu-200 py-4">
                <p>© {{ date('Y') }} Lazisnu MWC NU Balongbendo. All rights reserved.</p>
                <p class="mt-1">Dev by <a href="https://andidev.id" target="_blank" class="text-nu-400 hover:text-nu-300 font-medium">Bos Andi</a></p>
            </div>
        </footer>
    </div>

    <script>
        function previewKTP(input) {
            const preview = document.getElementById('ktp_preview');
            const previewImg = document.getElementById('ktp_preview_img');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
