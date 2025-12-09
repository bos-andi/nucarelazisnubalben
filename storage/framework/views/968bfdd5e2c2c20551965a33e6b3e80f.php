<?php $__env->startSection('title', 'Tambah Berita - Lazisnu Balongbendo'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Berita Baru</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Tambah Berita</h1>
            </div>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="text-sm font-semibold text-slate-500">Kembali</a>
        </div>

        <?php if($errors->any()): ?>
            <div class="mt-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-600 text-sm">
                <p class="font-semibold">Periksa kembali:</p>
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.articles.store')); ?>" method="POST" enctype="multipart/form-data" class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 p-8 space-y-6">
            <?php echo $__env->make('admin.articles.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/articles/create.blade.php ENDPATH**/ ?>