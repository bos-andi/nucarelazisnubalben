<?php $__env->startSection('title', 'Kelola Galeri - Lazisnu Balongbendo'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dashboard Media</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Galeri Foto &amp; Video</h1>
                <p class="text-sm text-slate-500 mt-1">Unggah dokumentasi kegiatan dan sematkan video YouTube/IG/TikTok.</p>
            </div>
            <a href="<?php echo e(route('admin.gallery.create')); ?>" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Tambah Media</a>
        </div>

        <div class="mt-8 grid md:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="<?php echo e($item->thumbnail_url ?? $item->media_url); ?>" alt="<?php echo e($item->title); ?>" class="h-48 w-full object-cover">
                        <span class="absolute top-3 left-3 px-3 py-1 text-xs rounded-full <?php echo e($item->type === 'video' ? 'bg-black/80 text-white' : 'bg-white/90 text-slate-700'); ?>">
                            <?php echo e(ucfirst($item->type)); ?>

                        </span>
                        <?php if($item->is_featured): ?>
                            <span class="absolute top-3 right-3 px-3 py-1 text-xs rounded-full bg-nu-600 text-white">Sorotan</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-xs uppercase tracking-[0.3em] text-nu-500"><?php echo e($item->type === 'video' ? 'Video' : 'Foto'); ?></p>
                        <h2 class="text-lg font-semibold text-slate-900 mt-2"><?php echo e($item->title); ?></h2>
                        <p class="text-sm text-slate-600 mt-2 flex-1"><?php echo e(Str::limit($item->description, 120)); ?></p>
                        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                            <span><?php echo e(optional($item->published_at)->translatedFormat('d M Y')); ?></span>
                            <a href="<?php echo e($item->media_url); ?>" target="_blank" class="text-nu-600 font-semibold">Buka media</a>
                        </div>
                        <div class="mt-4 flex gap-3">
                            <a href="<?php echo e(route('admin.gallery.edit', $item)); ?>" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="<?php echo e(route('admin.gallery.destroy', $item)); ?>" method="POST" onsubmit="return confirm('Hapus item galeri ini?')" class="text-xs font-semibold text-red-500">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button>Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="md:col-span-3 text-center text-slate-500 py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                    Belum ada dokumentasi.
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($items->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>