<?php $__env->startSection('title', 'Pengaturan Website - Lazisnu Balongbendo'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Website</h1>
            <p class="text-gray-600 mt-1">Kelola logo, judul, dan konten utama website</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 border border-red-200 rounded-xl bg-red-50 text-red-600 text-sm">
                <p class="font-semibold">Periksa kembali:</p>
                <ul class="list-disc list-inside mt-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- General Settings -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Umum</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Logo Website</label>
                        <input type="file" name="site_logo" accept="image/*" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <?php if($settings->get('site_logo')?->value): ?>
                            <div class="mt-3">
                                <img src="<?php echo e($settings->get('site_logo')->value); ?>" alt="Current logo" class="h-16 object-contain">
                                <p class="text-xs text-gray-500 mt-1">Logo saat ini</p>
                            </div>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-1">Upload logo (max 2MB). Akan otomatis di-resize maksimal tinggi 200px.</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Favicon (Icon di Tab Browser)</label>
                        <input type="file" name="site_favicon" accept="image/*" class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <?php if($settings->get('site_favicon')?->value): ?>
                            <div class="mt-3">
                                <img src="<?php echo e($settings->get('site_favicon')->value); ?>" alt="Current favicon" class="h-8 w-8 object-contain">
                                <p class="text-xs text-gray-500 mt-1">Favicon saat ini</p>
                            </div>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-1">Upload favicon (max 1MB). Akan otomatis di-resize menjadi 32x32px.</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Judul Website</label>
                        <input type="text" name="site_title" value="<?php echo e(old('site_title', $settings->get('site_title')?->value ?? 'Balongbendo Newsroom')); ?>" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Contoh: Balongbendo Newsroom</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-600">Subtitle Website</label>
                        <input type="text" name="site_subtitle" value="<?php echo e(old('site_subtitle', $settings->get('site_subtitle')?->value ?? 'Lazisnu MWC NU')); ?>" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Contoh: Lazisnu MWC NU</p>
                    </div>
                </div>
            </div>

            <!-- Homepage Settings -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Halaman Utama</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Judul Hero Section</label>
                        <input type="text" name="hero_title" value="<?php echo e(old('hero_title', $settings->get('hero_title')?->value ?? 'Kabar Kebaikan & Aksi Hijau Dari Bumi Balongbendo')); ?>" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Judul besar di halaman utama</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Deskripsi Hero Section</label>
                        <textarea name="hero_description" rows="3" required class="mt-2 w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('hero_description', $settings->get('hero_description')?->value ?? 'Menguatkan gerakan zakat, infak, sedekah, dan program sosial untuk menghadirkan kemandirian ekonomi umat.')); ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Deskripsi di bawah judul hero section</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl">
                    Simpan Pengaturan
                </button>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>