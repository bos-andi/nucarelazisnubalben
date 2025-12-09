<?php $__env->startSection('title', 'Kelola Kontributor'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900">Kelola Kontributor</h1>
            <p class="text-slate-600 mt-1">Setujui atau tolak pendaftaran kontributor baru</p>
        </div>

        <?php if(session('status')): ?>
            <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800"><?php echo e(session('status')); ?></p>
                
                <?php if(session('new_password')): ?>
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-blue-800 font-semibold">Password baru untuk <?php echo e(session('reset_user')); ?>:</p>
                        <div class="mt-2 flex items-center gap-2">
                            <code class="px-3 py-1 bg-blue-100 text-blue-900 rounded font-mono text-sm"><?php echo e(session('new_password')); ?></code>
                            <button onclick="copyPassword('<?php echo e(session('new_password')); ?>')" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                Copy
                            </button>
                        </div>
                        <p class="text-blue-700 text-sm mt-2">⚠️ Simpan password ini dan berikan kepada kontributor. Password tidak akan ditampilkan lagi.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mx-6 mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="text-red-800"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <!-- Pending Approvals -->
        <div class="p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Menunggu Persetujuan (<?php echo e($pendingContributors->count()); ?>)</h2>
            
            <?php if($pendingContributors->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Nama</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Tanggal Daftar</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendingContributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($contributor->avatar): ?>
                                                <img src="<?php echo e($contributor->avatar); ?>" alt="<?php echo e($contributor->name); ?>" class="w-8 h-8 rounded-full object-cover">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-full bg-nu-500 flex items-center justify-center text-white text-sm font-medium">
                                                    <?php echo e(substr($contributor->name, 0, 1)); ?>

                                                </div>
                                            <?php endif; ?>
                                            <span class="font-medium text-slate-900"><?php echo e($contributor->name); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600"><?php echo e($contributor->email); ?></td>
                                    <td class="py-4 px-4 text-slate-600"><?php echo e($contributor->created_at->format('d M Y, H:i')); ?></td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="<?php echo e(route('admin.contributors.approve', $contributor)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.contributors.reject', $contributor)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menolak dan menghapus kontributor ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                                    Tolak
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
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="mt-2 text-slate-500">Tidak ada kontributor yang menunggu persetujuan</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Approved Contributors -->
        <div class="p-6 border-t border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Kontributor Aktif (<?php echo e($approvedContributors->count()); ?>)</h2>
            
            <?php if($approvedContributors->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Nama</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">KTP</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Disetujui</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Artikel</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $approvedContributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($contributor->avatar): ?>
                                                <img src="<?php echo e($contributor->avatar); ?>" alt="<?php echo e($contributor->name); ?>" class="w-8 h-8 rounded-full object-cover">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-full bg-nu-500 flex items-center justify-center text-white text-sm font-medium">
                                                    <?php echo e(substr($contributor->name, 0, 1)); ?>

                                                </div>
                                            <?php endif; ?>
                                            <div class="flex items-center gap-2">
                                                <span class="font-medium text-slate-900"><?php echo e($contributor->name); ?></span>
                                                <?php if($contributor->is_ktp_verified): ?>
                                                    <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="KTP Terverifikasi">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600"><?php echo e($contributor->email); ?></td>
                                    <td class="py-4 px-4">
                                        <?php if($contributor->ktp_file): ?>
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e($contributor->ktp_file); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm underline">
                                                    Lihat KTP
                                                </a>
                                                <?php if($contributor->is_ktp_verified): ?>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs text-green-600 font-medium">✓ Terverifikasi</span>
                                                        <form action="<?php echo e(route('admin.contributors.unverify-ktp', $contributor)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mencabut verifikasi KTP?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium underline">
                                                                Cabut
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if($contributor->ktp_file): ?>
                                                        <form action="<?php echo e(route('admin.contributors.verify-ktp', $contributor)); ?>" method="POST" class="inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline">
                                                                Verifikasi
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400">Belum upload</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        <?php echo e($contributor->approved_at?->format('d M Y')); ?>

                                        <?php if($contributor->approver): ?>
                                            <br><span class="text-xs text-slate-500">oleh <?php echo e($contributor->approver->name); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600"><?php echo e($contributor->articles()->count()); ?> artikel</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">
                                            <!-- Atur Permission Button -->
                                            <button onclick="openPermissionModal(<?php echo e($contributor->id); ?>, '<?php echo e($contributor->name); ?>', <?php echo e(json_encode($contributor->permissions->pluck('id')->toArray())); ?>)" 
                                                    class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                                                🔐 Atur Permission
                                            </button>
                                            
                                            <!-- Reset Password Button -->
                                            <button onclick="openPasswordModal(<?php echo e($contributor->id); ?>, '<?php echo e($contributor->name); ?>')" 
                                                    class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Reset Password
                                            </button>
                                            
                                            <!-- Revoke Access Button -->
                                            <form action="<?php echo e(route('admin.contributors.revoke', $contributor)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mencabut persetujuan kontributor ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="px-3 py-1.5 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors">
                                                    Cabut Akses
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
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="mt-2 text-slate-500">Belum ada kontributor yang disetujui</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Reset Password Kontributor</h3>
                    <button onclick="closePasswordModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <p class="text-slate-600 mb-6">Pilih cara reset password untuk kontributor <span id="contributorName" class="font-semibold"></span>:</p>
                
                <div class="space-y-4">
                    <!-- Auto Generate Password -->
                    <div>
                        <form id="autoResetForm" method="POST" class="w-full">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Generate Password Otomatis</p>
                                        <p class="text-sm text-blue-100">Sistem akan membuat password acak 12 karakter</p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Manual Password -->
                    <div>
                        <button onclick="toggleManualForm()" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-left">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold">Set Password Manual</p>
                                    <p class="text-sm text-green-100">Atur password sesuai keinginan</p>
                                </div>
                            </div>
                        </button>
                        
                        <div id="manualForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg">
                            <form id="manualResetForm" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                                        <input type="password" name="new_password" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" minlength="8" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                                        <input type="password" name="new_password_confirmation" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" minlength="8" required>
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openPasswordModal(contributorId, contributorName) {
    document.getElementById('contributorName').textContent = contributorName;
    document.getElementById('autoResetForm').action = `/dashboard/contributors/${contributorId}/reset-password`;
    document.getElementById('manualResetForm').action = `/dashboard/contributors/${contributorId}/change-password`;
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
    document.getElementById('manualForm').classList.add('hidden');
}

function toggleManualForm() {
    document.getElementById('manualForm').classList.toggle('hidden');
}

function copyPassword(password) {
    navigator.clipboard.writeText(password).then(function() {
        alert('Password berhasil disalin ke clipboard!');
    });
}

// Close modal when clicking outside
document.getElementById('passwordModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePasswordModal();
    }
});

// Permission Modal Functions
function openPermissionModal(userId, userName, currentPermissions) {
    document.getElementById('permissionUserName').textContent = userName;
    document.getElementById('permissionForm').action = `/dashboard/permissions/${userId}`;
    
    // Uncheck all checkboxes first
    document.querySelectorAll('#permissionModal input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });
    
    // Check current permissions
    if (currentPermissions && currentPermissions.length > 0) {
        currentPermissions.forEach(permissionId => {
            const checkbox = document.getElementById(`permission_${permissionId}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
    
    document.getElementById('permissionModal').classList.remove('hidden');
}

function closePermissionModal() {
    document.getElementById('permissionModal').classList.add('hidden');
}

// Close permission modal when clicking outside
document.getElementById('permissionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePermissionModal();
    }
});
</script>

<!-- Permission Modal -->
<div id="permissionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full my-8">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">🔐 Atur Permission</h3>
                        <p class="text-sm text-slate-600 mt-1">Untuk: <span id="permissionUserName" class="font-medium"></span></p>
                    </div>
                    <button onclick="closePermissionModal()" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="permissionForm" method="POST" action="">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2">
                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupPermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                    <?php if($group === 'content'): ?>
                                        📝 Konten
                                    <?php elseif($group === 'master_data'): ?>
                                        📊 Master Data
                                    <?php elseif($group === 'users'): ?>
                                        👥 Pengguna
                                    <?php elseif($group === 'settings'): ?>
                                        ⚙️ Pengaturan
                                    <?php else: ?>
                                        <?php echo e(ucfirst(str_replace('_', ' ', $group))); ?>

                                    <?php endif; ?>
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <?php $__currentLoopData = $groupPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-start p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer bg-white">
                                            <input type="checkbox" 
                                                   id="permission_<?php echo e($permission->id); ?>"
                                                   name="permissions[]" 
                                                   value="<?php echo e($permission->id); ?>"
                                                   class="mt-1 rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900"><?php echo e($permission->display_name); ?></p>
                                                <?php if($permission->description): ?>
                                                    <p class="text-xs text-gray-500 mt-1"><?php echo e($permission->description); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
                        <button type="button" onclick="closePermissionModal()" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-nu-600 text-white rounded-lg hover:bg-nu-700 transition-colors">
                            💾 Simpan Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\lazisnubalongbendo\resources\views/admin/contributors/index.blade.php ENDPATH**/ ?>