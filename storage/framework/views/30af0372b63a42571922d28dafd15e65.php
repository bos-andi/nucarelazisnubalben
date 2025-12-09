

<?php $__env->startSection('title', 'Masuk - Lazisnu Balongbendo'); ?>

<?php $__env->startSection('content'); ?>
    <section class="max-w-xl mx-auto px-6 py-16">
        <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 p-8">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Dashboard</p>
            <h1 class="text-3xl font-bold text-slate-900 mt-2">Masuk Admin</h1>
            <p class="text-sm text-slate-500 mt-1">Gunakan akun superadmin atau kontributor.</p>

            <?php if($errors->any()): ?>
                <div class="mt-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-600 text-sm">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login')); ?>" method="POST" class="mt-8 space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-600">Password</label>
                    <input type="password" name="password" required
                           class="mt-2 w-full rounded-2xl border-slate-200 focus:ring-nu-500 focus:border-nu-500">
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" id="remember" class="rounded text-nu-600 focus:ring-nu-600">
                    <label for="remember">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-nu-600 text-white font-semibold py-3 rounded-2xl hover:bg-nu-700">
                    Masuk
                </button>
            </form>

            <!-- Forgot Password Link -->
            <div class="text-center mt-4">
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-nu-600 hover:text-nu-800 font-medium transition-colors">
                    Lupa password?
                </a>
            </div>

            <p class="text-sm text-center text-slate-500 mt-6">
                Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="text-nu-600 font-semibold">Daftar kontributor</a>
            </p>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/auth/login.blade.php ENDPATH**/ ?>