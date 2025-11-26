@csrf
@if(isset($item))
    @method('PUT')
@endif
<div class="grid md:grid-cols-2 gap-6">
    <div>
        <label class="text-sm font-semibold text-slate-600">Judul*</label>
        <input type="text" name="title" value="{{ old('title', $item->title ?? null) }}" required class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Jenis Media*</label>
        <select name="type" required class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
            <option value="photo" @selected(old('type', $item->type ?? null) === 'photo')>Foto</option>
            <option value="video" @selected(old('type', $item->type ?? null) === 'video')>Video</option>
        </select>
    </div>
    <div id="photo-upload" style="display: none;">
        <label class="text-sm font-semibold text-slate-600">Upload Gambar*</label>
        <input type="file" name="images[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.bmp,.tiff,image/*" 
               class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100"
               id="gallery_images_input" onchange="previewGalleryImages(this)">
        
        <!-- Current Image Preview -->
        @if(isset($item) && $item->type === 'photo' && $item->media_url)
            <div class="mt-3" id="current_gallery_preview">
                <p class="text-xs font-semibold text-slate-600 mb-2">Gambar Saat Ini:</p>
                <div class="relative inline-block">
                    <img src="{{ $item->media_url }}" alt="Current image" class="w-48 h-32 object-cover rounded-lg border-2 border-slate-200 shadow-sm">
                    <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Tersimpan</div>
                </div>
            </div>
        @endif
        
        <!-- New Images Preview -->
        <div class="mt-3 hidden" id="new_gallery_preview">
            <p class="text-xs font-semibold text-slate-600 mb-2">Preview Gambar Baru:</p>
            <div id="gallery_preview_container" class="grid grid-cols-2 md:grid-cols-3 gap-3"></div>
        </div>
        
        <p class="text-xs text-slate-400 mt-2">Format yang didukung: JPG, JPEG, PNG, GIF, WEBP, BMP, TIFF (maksimal 10MB per gambar). Gambar akan otomatis di-resize.</p>
    </div>
    <div id="video-upload" style="display: none;">
        <label class="text-sm font-semibold text-slate-600">URL Video (YouTube/Embed)*</label>
        <input type="url" name="video_url" value="{{ old('video_url', isset($item) && $item->type === 'video' ? $item->media_url : null) }}" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" placeholder="https://www.youtube.com/embed/...">
        <p class="text-xs text-slate-400 mt-1">Masukkan URL embed video dari YouTube, Vimeo, dll.</p>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Tanggal Publikasi</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', isset($item) && $item->published_at ? $item->published_at->format('Y-m-d\TH:i') : null) }}" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
</div>
<div class="mt-6">
    <label class="text-sm font-semibold text-slate-600">Deskripsi</label>
    <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">{{ old('description', $item->description ?? null) }}</textarea>
</div>
<div class="mt-6 flex items-center gap-3">
    <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded text-nu-600 focus:ring-nu-600" {{ old('is_featured', $item->is_featured ?? false) ? 'checked' : '' }}>
    <label for="is_featured" class="text-sm text-slate-600">Tandai sebagai sorotan</label>
</div>
<div class="mt-8 flex gap-3">
    <button class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700">Simpan</button>
    <a href="{{ route('admin.gallery.index') }}" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600">Batal</a>
</div>

<script>
function previewGalleryImages(input) {
    const files = input.files;
    const newPreview = document.getElementById('new_gallery_preview');
    const previewContainer = document.getElementById('gallery_preview_container');
    
    // Clear previous previews
    previewContainer.innerHTML = '';
    
    if (files && files.length > 0) {
        newPreview.classList.remove('hidden');
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative';
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg border-2 border-blue-200 shadow-sm">
                    <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 py-0.5 rounded">${index + 1}</div>
                `;
                previewContainer.appendChild(previewDiv);
            };
            reader.readAsDataURL(file);
        });
    } else {
        newPreview.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    const photoUpload = document.getElementById('photo-upload');
    const videoUpload = document.getElementById('video-upload');

    function toggleUploadType() {
        if (typeSelect.value === 'photo') {
            photoUpload.style.display = 'block';
            videoUpload.style.display = 'none';
            photoUpload.querySelector('input[name="images[]"]').required = true;
            videoUpload.querySelector('input[name="video_url"]').required = false;
        } else {
            photoUpload.style.display = 'none';
            videoUpload.style.display = 'block';
            photoUpload.querySelector('input[name="images[]"]').required = false;
            videoUpload.querySelector('input[name="video_url"]').required = true;
        }
    }

    typeSelect.addEventListener('change', toggleUploadType);
    
    // Initialize on page load
    toggleUploadType();
});
</script>

