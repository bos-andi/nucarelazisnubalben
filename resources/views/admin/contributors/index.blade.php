@extends('layouts.admin')

@section('title', 'Kelola Kontributor')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900">Kelola Kontributor</h1>
            <p class="text-slate-600 mt-1">Setujui atau tolak pendaftaran kontributor baru</p>
        </div>

        @if (session('status'))
            <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('status') }}</p>
                
                @if (session('new_password'))
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-blue-800 font-semibold">Password baru untuk {{ session('reset_user') }}:</p>
                        <div class="mt-2 flex items-center gap-2">
                            <code class="px-3 py-1 bg-blue-100 text-blue-900 rounded font-mono text-sm">{{ session('new_password') }}</code>
                            <button onclick="copyPassword('{{ session('new_password') }}')" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                Copy
                            </button>
                        </div>
                        <p class="text-blue-700 text-sm mt-2">⚠️ Simpan password ini dan berikan kepada kontributor. Password tidak akan ditampilkan lagi.</p>
                    </div>
                @endif
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-6 mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-red-800">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Pending Approvals -->
        <div class="p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Menunggu Persetujuan ({{ $pendingContributors->count() }})</h2>
            
            @if ($pendingContributors->count() > 0)
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
                            @foreach ($pendingContributors as $contributor)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            @if ($contributor->avatar)
                                                <img src="{{ $contributor->avatar }}" alt="{{ $contributor->name }}" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-nu-500 flex items-center justify-center text-white text-sm font-medium">
                                                    {{ substr($contributor->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="font-medium text-slate-900">{{ $contributor->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">{{ $contributor->email }}</td>
                                    <td class="py-4 px-4 text-slate-600">{{ $contributor->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.contributors.approve', $contributor) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.contributors.reject', $contributor) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menolak dan menghapus kontributor ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="mt-2 text-slate-500">Tidak ada kontributor yang menunggu persetujuan</p>
                </div>
            @endif
        </div>

        <!-- Approved Contributors -->
        <div class="p-6 border-t border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Kontributor Aktif ({{ $approvedContributors->count() }})</h2>
            
            @if ($approvedContributors->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Nama</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Disetujui</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Artikel</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvedContributors as $contributor)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            @if ($contributor->avatar)
                                                <img src="{{ $contributor->avatar }}" alt="{{ $contributor->name }}" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-nu-500 flex items-center justify-center text-white text-sm font-medium">
                                                    {{ substr($contributor->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="font-medium text-slate-900">{{ $contributor->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">{{ $contributor->email }}</td>
                                    <td class="py-4 px-4 text-slate-600">
                                        {{ $contributor->approved_at?->format('d M Y') }}
                                        @if ($contributor->approver)
                                            <br><span class="text-xs text-slate-500">oleh {{ $contributor->approver->name }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">{{ $contributor->articles()->count() }} artikel</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Reset Password Button -->
                                            <button onclick="openPasswordModal({{ $contributor->id }}, '{{ $contributor->name }}')" 
                                                    class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Reset Password
                                            </button>
                                            
                                            <!-- Revoke Access Button -->
                                            <form action="{{ route('admin.contributors.revoke', $contributor) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mencabut persetujuan kontributor ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors">
                                                    Cabut Akses
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="mt-2 text-slate-500">Belum ada kontributor yang disetujui</p>
                </div>
            @endif
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
                            @csrf
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
                                @csrf
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
</script>
@endsection

