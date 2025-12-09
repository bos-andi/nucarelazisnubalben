<?php $__env->startSection('title', 'Kelola Berita - Lazisnu Balongbendo'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dashboard</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Kelola Berita</h1>
                <p class="text-sm text-slate-500 mt-1">Tambah, ubah, dan publikasikan kabar terbaru Lazisnu.</p>
            </div>
            <a href="<?php echo e(route('admin.articles.create')); ?>" class="bg-nu-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-nu-700 text-center">+ Tambah Berita</a>
        </div>

        <form method="GET" class="mt-8 grid md:grid-cols-3 gap-3">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul atau penulis..." class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
            <select name="category_id" class="rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                <option value="">Semua kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if(request('category_id') == $category->id): echo 'selected'; endif; ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-semibold">Terapkan</button>
        </form>

        <div class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wide">
                <tr>
                    <th class="text-left px-6 py-4">Thumbnail</th>
                    <th class="text-left px-6 py-4">Judul</th>
                    <th class="text-left px-6 py-4">Kategori</th>
                    <th class="text-left px-6 py-4">Penulis</th>
                    <th class="text-left px-6 py-4">Terbit</th>
                    <th class="text-center px-6 py-4">Unggulan</th>
                    <th class="px-6 py-4"></th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-slate-100 hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <?php if($article->thumbnail): ?>
                                <img src="<?php echo e($article->thumbnail); ?>" alt="<?php echo e($article->title); ?>" class="w-16 h-12 object-cover rounded-lg border border-slate-200">
                            <?php elseif($article->cover_image): ?>
                                <img src="<?php echo e($article->cover_image); ?>" alt="<?php echo e($article->title); ?>" class="w-16 h-12 object-cover rounded-lg border border-slate-200">
                            <?php else: ?>
                                <div class="w-16 h-12 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900"><?php echo e($article->title); ?></p>
                            <p class="text-xs text-slate-500">Slug: <?php echo e($article->slug); ?></p>
                        </td>
                        <td class="px-6 py-4 text-slate-600"><?php echo e($article->category->name ?? '-'); ?></td>
                        <td class="px-6 py-4 text-slate-600"><?php echo e($article->author ?? 'Tim Lazisnu'); ?></td>
                        <td class="px-6 py-4 text-slate-600"><?php echo e(optional($article->published_at)->translatedFormat('d M Y H:i')); ?></td>
                        <td class="px-6 py-4 text-center">
                            <?php if($article->is_featured): ?>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-nu-100 text-nu-700">Ya</span>
                            <?php else: ?>
                                <span class="text-xs text-slate-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right flex flex-wrap gap-2">
                            <a href="<?php echo e(route('articles.show', $article)); ?>" target="_blank" class="text-nu-600 text-xs font-semibold">Lihat</a>
                            <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="text-xs font-semibold text-slate-600">Edit</a>
                            <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-500">Belum ada berita.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <?php echo e($articles->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/articles/index.blade.php ENDPATH**/ ?>