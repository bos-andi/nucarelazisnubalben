<?php $__env->startSection('title', 'Kelola Khutbah Jum\'at'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Khutbah Jum'at</h1>
                <p class="text-slate-600 mt-1">Atur khutbah Jum'at yang ditampilkan di website</p>
            </div>
            <a href="<?php echo e(route('admin.khutbah.create')); ?>" class="bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                Tambah Khutbah
            </a>
        </div>

        <?php if(session('status')): ?>
            <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800"><?php echo e(session('status')); ?></p>
            </div>
        <?php endif; ?>

        <div class="p-6">
            <?php if($khutbahs->count() > 0): ?>
                <div class="mb-4">
                    <form action="<?php echo e(route('admin.khutbah.index')); ?>" method="GET" class="flex gap-3">
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari khutbah..." 
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nu-500 focus:border-transparent">
                        <button type="submit" class="bg-nu-600 text-white px-6 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                            Cari
                        </button>
                        <?php if(request('q')): ?>
                            <a href="<?php echo e(route('admin.khutbah.index')); ?>" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors">
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Tanggal</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Judul</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Khatib</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Lokasi</th>
                                <?php if(auth()->user()->isSuperAdmin()): ?>
                                    <th class="text-left py-3 px-4 font-medium text-slate-700">Pembuat</th>
                                <?php endif; ?>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Status</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $khutbahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $khutbah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4 text-slate-600">
                                        <?php echo e($khutbah->khutbah_date->translatedFormat('d M Y')); ?>

                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-medium text-slate-900"><?php echo e($khutbah->title); ?></span>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        <?php echo e($khutbah->khatib ?? '-'); ?>

                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        <?php echo e($khutbah->location ?? '-'); ?>

                                    </td>
                                    <?php if(auth()->user()->isSuperAdmin()): ?>
                                        <td class="py-4 px-4 text-slate-600">
                                            <?php echo e($khutbah->user->name ?? '-'); ?>

                                        </td>
                                    <?php endif; ?>
                                    <td class="py-4 px-4 text-center">
                                        <?php if($khutbah->is_published): ?>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Published</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="<?php echo e(route('admin.khutbah.edit', $khutbah)); ?>" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.khutbah.destroy', $khutbah)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus khutbah ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="mt-4 text-slate-500">Belum ada khutbah yang ditambahkan</p>
                    <a href="<?php echo e(route('admin.khutbah.create')); ?>" class="mt-4 inline-block bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                        Tambah Khutbah Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/khutbah/index.blade.php ENDPATH**/ ?>