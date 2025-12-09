<?php echo csrf_field(); ?>
<?php if(isset($article)): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>
<div class="grid md:grid-cols-2 gap-6">
    <div>
        <label class="text-sm font-semibold text-slate-600">Judul*</label>
        <input type="text" name="title" value="<?php echo e(old('title', $article->title ?? null)); ?>" required class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Slug (opsional)</label>
        <input type="text" name="slug" value="<?php echo e(old('slug', $article->slug ?? null)); ?>" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500" placeholder="otomatis bila dikosongkan">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Kategori</label>
        <select name="category_id" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
            <option value="">Pilih kategori</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php if(old('category_id', $article->category_id ?? null) == $category->id): echo 'selected'; endif; ?>>
                    <?php echo e($category->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <p class="text-xs text-slate-400 mt-1">Butuh kategori baru? Superadmin dapat menambah lewat menu Master Data.</p>
    </div>
    <!-- Penulis otomatis diambil dari user yang login -->
    <div>
        <label class="text-sm font-semibold text-slate-600">Gambar Utama</label>
        <input type="file" name="cover_image" accept=".jpg,.jpeg,.png,.gif,.webp,.bmp,.tiff,image/*" 
               class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-nu-50 file:text-nu-700 hover:file:bg-nu-100"
               id="cover_image_input" onchange="previewImage(this)">
        
        <!-- Current Image Preview -->
        <?php if(isset($article) && $article->cover_image): ?>
            <div class="mt-3 space-y-3" id="current_image_preview">
                <div>
                    <p class="text-xs font-semibold text-slate-600 mb-2">Gambar Utama Saat Ini:</p>
                    <div class="relative inline-block">
                        <img src="<?php echo e($article->cover_image); ?>" alt="Current cover" class="w-48 h-32 object-cover rounded-lg border-2 border-slate-200 shadow-sm">
                        <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Tersimpan</div>
                    </div>
                </div>
                <?php if(isset($article) && $article->thumbnail): ?>
                    <div>
                        <p class="text-xs font-semibold text-slate-600 mb-2">Thumbnail (Otomatis dari Gambar Utama):</p>
                        <div class="relative inline-block">
                            <img src="<?php echo e($article->thumbnail); ?>" alt="Current thumbnail" class="w-32 h-24 object-cover rounded-lg border-2 border-green-200 shadow-sm">
                            <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Thumbnail</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- New Image Preview -->
        <div class="mt-3 hidden space-y-3" id="new_image_preview">
            <div>
                <p class="text-xs font-semibold text-slate-600 mb-2">Preview Gambar Utama:</p>
                <div class="relative inline-block">
                    <img id="preview_img" src="" alt="Preview" class="w-48 h-32 object-cover rounded-lg border-2 border-blue-200 shadow-sm">
                    <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">Preview</div>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-600 mb-2">Thumbnail akan otomatis dibuat dari gambar utama (400x300px)</p>
            </div>
        </div>
        
        <p class="text-xs text-slate-400 mt-2">Format yang didukung: JPG, JPEG, PNG, GIF, WEBP, BMP, TIFF (maksimal 10MB). Thumbnail akan otomatis dibuat dari gambar utama (400x300px).</p>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-600">Tanggal Terbit</label>
        <input type="datetime-local" name="published_at" value="<?php echo e(old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : null)); ?>" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
    </div>
</div>
<div class="mt-6">
    <label class="text-sm font-semibold text-slate-600">Tag (opsional)</label>
    <div class="mt-2 p-4 border border-slate-200 rounded-2xl max-h-64 overflow-y-auto">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center space-x-2 cursor-pointer hover:bg-slate-50 p-2 rounded-lg transition">
                    <input type="checkbox" name="tag_ids[]" value="<?php echo e($tag->id); ?>" 
                           class="rounded text-nu-600 focus:ring-nu-600"
                           <?php if(in_array($tag->id, old('tag_ids', isset($article) ? $article->tags->pluck('id')->toArray() : []))): echo 'checked'; endif; ?>>
                    <span class="text-sm text-slate-700"><?php echo e($tag->name); ?></span>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($tags->isEmpty()): ?>
            <p class="text-sm text-slate-400 text-center py-4">Belum ada tag. Superadmin dapat menambah lewat menu Master Data.</p>
        <?php endif; ?>
    </div>
    <p class="text-xs text-slate-400 mt-1">Pilih satu atau lebih tag untuk artikel ini.</p>
</div>
<div class="mt-6">
    <label class="text-sm font-semibold text-slate-600">Ringkasan</label>
    <textarea name="excerpt" rows="3" class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500"><?php echo e(old('excerpt', $article->excerpt ?? null)); ?></textarea>
</div>
<div class="mt-6">
    <label class="text-sm font-semibold text-slate-600">Konten</label>
    <input type="hidden" name="body" id="body-input" value="<?php echo e(old('body', $article->body ?? null)); ?>" required>
    <div id="quill-editor" class="mt-2 bg-white rounded-2xl border border-slate-200" style="min-height: 300px;"></div>
    <p class="text-xs text-slate-400 mt-1">Gunakan toolbar untuk format teks, tambah gambar, dan styling lainnya.</p>
</div>
<div class="mt-6 flex items-center gap-3">
    <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded text-nu-600 focus:ring-nu-600" <?php echo e(old('is_featured', $article->is_featured ?? false) ? 'checked' : ''); ?>>
    <label for="is_featured" class="text-sm text-slate-600">Tampilkan sebagai berita unggulan</label>
</div>
<div class="mt-8 flex gap-4">
    <button type="submit" class="bg-nu-600 hover:bg-nu-700 text-white font-semibold px-6 py-3 rounded-2xl">
        Simpan Berita
    </button>
    <a href="<?php echo e(route('admin.articles.index')); ?>" class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600">Batal</a>
</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    const newPreview = document.getElementById('new_image_preview');
    const previewImg = document.getElementById('preview_img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            newPreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        newPreview.classList.add('hidden');
    }
}
</script>

<?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/articles/form.blade.php ENDPATH**/ ?>