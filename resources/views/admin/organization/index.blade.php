@extends('layouts.admin')

@section('title', 'Kelola Organisasi')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Kelola Organisasi</h1>
        <p class="text-slate-600 mt-2">Kelola sambutan dan struktur organisasi Lazisnu MWC NU Balongbendo</p>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Sambutan Section -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8">
            <div class="flex items-center mb-6">
                <div class="bg-nu-100 p-3 rounded-2xl mr-4">
                    <svg class="w-6 h-6 text-nu-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V8m10 0H7"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Sambutan Ketua</h2>
                    <p class="text-sm text-slate-600">Kelola pesan sambutan dari ketua organisasi</p>
                </div>
            </div>

            <form action="{{ route('admin.organization.update-welcome') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Judul Sambutan*</label>
                    <input type="text" name="title" value="{{ old('title', $welcomeMessage->title ?? 'Sambutan Ketua') }}" 
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" 
                           placeholder="Sambutan Ketua" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Isi Sambutan*</label>
                    <textarea name="content" rows="6" 
                              class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" 
                              placeholder="Tulis pesan sambutan dari ketua..." required>{{ old('content', $welcomeMessage->content ?? '') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Chairman Photo -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Foto Ketua</label>
                    <input type="file" name="chairman_photo" accept="image/*" 
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100"
                           onchange="previewChairmanPhoto(this)">
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, GIF, WEBP (maksimal 10MB)</p>
                    @error('chairman_photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Current Photo Preview -->
                    @if(isset($welcomeMessage) && $welcomeMessage->chairman_photo)
                        <div class="mt-3" id="current_chairman_photo">
                            <p class="text-xs font-semibold text-slate-600 mb-2">Foto Saat Ini:</p>
                            <div class="relative inline-block">
                                <img src="{{ $welcomeMessage->chairman_photo }}" class="w-24 h-24 object-cover rounded-full border-2 border-slate-200 shadow-sm">
                                <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Tersimpan</div>
                            </div>
                        </div>
                    @endif

                    <!-- New Photo Preview -->
                    <div class="mt-3 hidden" id="new_chairman_photo_preview">
                        <p class="text-xs font-semibold text-slate-600 mb-2">Preview Foto Baru:</p>
                        <div class="relative inline-block">
                            <img id="chairman_preview_img" class="w-24 h-24 object-cover rounded-full border-2 border-blue-200 shadow-sm">
                            <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">Preview</div>
                        </div>
                    </div>
                </div>

                <!-- Background Image -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Gambar Latar (Opsional)</label>
                    <input type="file" name="image" accept="image/*" 
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100"
                           onchange="previewWelcomeImage(this)">
                    <p class="text-xs text-slate-400 mt-1">Gambar latar untuk bagian sambutan</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Current Background Image Preview -->
                    @if(isset($welcomeMessage) && $welcomeMessage->image)
                        <div class="mt-3" id="current_welcome_image">
                            <p class="text-xs font-semibold text-slate-600 mb-2">Gambar Latar Saat Ini:</p>
                            <div class="relative inline-block">
                                <img src="{{ $welcomeMessage->image }}" class="w-48 h-32 object-cover rounded-lg border-2 border-slate-200 shadow-sm">
                                <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Tersimpan</div>
                            </div>
                        </div>
                    @endif

                    <!-- New Background Image Preview -->
                    <div class="mt-3 hidden" id="new_welcome_image_preview">
                        <p class="text-xs font-semibold text-slate-600 mb-2">Preview Gambar Latar Baru:</p>
                        <div class="relative inline-block">
                            <img id="welcome_preview_img" class="w-48 h-32 object-cover rounded-lg border-2 border-blue-200 shadow-sm">
                            <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">Preview</div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $welcomeMessage->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                    <label class="ml-2 text-sm text-slate-600">Aktifkan sambutan</label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-nu-600 hover:bg-nu-700 text-white font-semibold py-3 px-6 rounded-2xl transition-colors duration-200">
                        Simpan Sambutan
                    </button>
                </div>
            </form>
        </div>

        <!-- Structure Section -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8">
            <div class="flex items-center mb-6">
                <div class="bg-nu-100 p-3 rounded-2xl mr-4">
                    <svg class="w-6 h-6 text-nu-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Struktur Organisasi</h2>
                    <p class="text-sm text-slate-600">Kelola susunan pengurus organisasi</p>
                </div>
            </div>

            <form action="{{ route('admin.organization.update-structure') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="structure-form">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Judul Struktur*</label>
                    <input type="text" name="title" value="{{ old('title', $organizationStructure->title ?? 'Struktur Organisasi') }}" 
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" 
                           placeholder="Struktur Organisasi" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="text-sm font-semibold text-slate-600">Deskripsi (Opsional)</label>
                    <textarea name="content" rows="3" 
                              class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" 
                              placeholder="Deskripsi tentang struktur organisasi...">{{ old('content', $organizationStructure->content ?? '') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Positions -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-sm font-semibold text-slate-600">Daftar Pengurus</label>
                        <button type="button" onclick="addPosition()" class="bg-nu-600 hover:bg-nu-700 text-white text-sm font-semibold py-2 px-4 rounded-xl transition-colors duration-200">
                            + Tambah Pengurus
                        </button>
                    </div>

                    <div id="positions-container" class="space-y-4">
                        @if(isset($organizationStructure) && $organizationStructure->data && isset($organizationStructure->data['positions']))
                            @foreach($organizationStructure->data['positions'] as $index => $position)
                                <div class="position-item border border-slate-200 rounded-2xl p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-semibold text-slate-600">Nama*</label>
                                            <input type="text" name="positions[{{ $index }}][name]" value="{{ $position['name'] }}" 
                                                   class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                                                   placeholder="Nama lengkap" required>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-slate-600">Jabatan*</label>
                                            <input type="text" name="positions[{{ $index }}][title]" value="{{ $position['title'] }}" 
                                                   class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                                                   placeholder="Jabatan" required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-slate-600">Deskripsi</label>
                                            <textarea name="positions[{{ $index }}][description]" rows="2" 
                                                      class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                                                      placeholder="Deskripsi singkat...">{{ $position['description'] ?? '' }}</textarea>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-slate-600">Urutan</label>
                                            <input type="number" name="positions[{{ $index }}][order]" value="{{ $position['order'] ?? 0 }}" 
                                                   class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                                                   placeholder="0" min="0">
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="positions[{{ $index }}][is_chairman]" value="1" 
                                                   {{ isset($position['is_chairman']) && $position['is_chairman'] ? 'checked' : '' }}
                                                   class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                                            <label class="ml-2 text-xs text-slate-600">Ketua</label>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-slate-600">Foto Pengurus</label>
                                            <input type="file" name="position_photos[{{ $index }}]" accept="image/*" 
                                                   class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-xs file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100">
                                            @if(isset($position['photo']) && $position['photo'])
                                                <div class="mt-2">
                                                    <img src="{{ $position['photo'] }}" class="w-16 h-16 object-cover rounded-full border-2 border-slate-200">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <button type="button" onclick="removePosition(this)" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                                            Hapus Pengurus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $organizationStructure->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                    <label class="ml-2 text-sm text-slate-600">Aktifkan struktur organisasi</label>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-nu-600 hover:bg-nu-700 text-white font-semibold py-3 px-6 rounded-2xl transition-colors duration-200">
                        Simpan Struktur Organisasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let positionIndex = {{ isset($organizationStructure) && $organizationStructure->data && isset($organizationStructure->data['positions']) ? count($organizationStructure->data['positions']) : 0 }};

function addPosition() {
    const container = document.getElementById('positions-container');
    const positionHtml = `
        <div class="position-item border border-slate-200 rounded-2xl p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-600">Nama*</label>
                    <input type="text" name="positions[${positionIndex}][name]" 
                           class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                           placeholder="Nama lengkap" required>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Jabatan*</label>
                    <input type="text" name="positions[${positionIndex}][title]" 
                           class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                           placeholder="Jabatan" required>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-slate-600">Deskripsi</label>
                    <textarea name="positions[${positionIndex}][description]" rows="2" 
                              class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                              placeholder="Deskripsi singkat..."></textarea>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Urutan</label>
                    <input type="number" name="positions[${positionIndex}][order]" value="0" 
                           class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-sm" 
                           placeholder="0" min="0">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="positions[${positionIndex}][is_chairman]" value="1" 
                           class="rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                    <label class="ml-2 text-xs text-slate-600">Ketua</label>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-slate-600">Foto Pengurus</label>
                    <input type="file" name="position_photos[${positionIndex}]" accept="image/*" 
                           class="mt-1 w-full rounded-xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 text-xs file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100">
                </div>
            </div>
            <div class="mt-4 text-right">
                <button type="button" onclick="removePosition(this)" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                    Hapus Pengurus
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', positionHtml);
    positionIndex++;
}

function removePosition(button) {
    button.closest('.position-item').remove();
}

// Preview functions
function previewChairmanPhoto(input) {
    const file = input.files[0];
    const newPreview = document.getElementById('new_chairman_photo_preview');
    const previewImg = document.getElementById('chairman_preview_img');
    const currentPreview = document.getElementById('current_chairman_photo');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            newPreview.classList.remove('hidden');
            if (currentPreview) {
                currentPreview.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    } else {
        newPreview.classList.add('hidden');
        if (currentPreview) {
            currentPreview.classList.remove('hidden');
        }
    }
}

function previewWelcomeImage(input) {
    const file = input.files[0];
    const newPreview = document.getElementById('new_welcome_image_preview');
    const previewImg = document.getElementById('welcome_preview_img');
    const currentPreview = document.getElementById('current_welcome_image');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            newPreview.classList.remove('hidden');
            if (currentPreview) {
                currentPreview.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    } else {
        newPreview.classList.add('hidden');
        if (currentPreview) {
            currentPreview.classList.remove('hidden');
        }
    }
}
</script>
@endsection
