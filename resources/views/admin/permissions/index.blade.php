@extends('layouts.admin')

@section('title', 'Kelola Permission')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">🔐 Kelola Permission</h1>
            <p class="text-gray-600 mt-1">Atur permission untuk setiap user (kecuali superadmin)</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('status') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        @if($users->count() > 0)
            <!-- Search Bar -->
            <div class="mb-6">
                <input type="text" 
                       id="userSearch" 
                       placeholder="Cari user berdasarkan nama atau email..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-nu-500 focus:border-nu-500">
            </div>

            <!-- Users List with Accordion -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="p-6">
                    <div class="space-y-4" id="usersList">
                        @foreach($users as $index => $user)
                            <div class="user-item border border-slate-200 rounded-lg overflow-hidden" data-user-name="{{ strtolower($user->name) }}" data-user-email="{{ strtolower($user->email) }}">
                                <!-- User Header (Clickable to expand/collapse) -->
                                <button type="button" 
                                        class="w-full flex items-center justify-between p-4 hover:bg-slate-50 transition-colors user-header cursor-pointer"
                                        data-user-index="{{ $index }}"
                                        onclick="toggleUserAccordion({{ $index }}, this)"
                                        aria-expanded="false"
                                        style="z-index: 1;">
                                    <div class="flex items-center gap-4">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-nu-500 flex items-center justify-center text-white font-semibold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="text-left">
                                            <h3 class="text-base font-semibold text-gray-900">{{ $user->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500">
                                                Role: <span class="font-medium">{{ ucfirst($user->role) }}</span>
                                            </p>
                                            <div class="mt-1">
                                                @if($user->is_approved)
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs">Approved</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200 user-arrow" id="arrow{{ $index }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>

                                <!-- Permission Form (Collapsible) -->
                                <div class="user-permissions hidden border-t border-slate-200 bg-slate-50" id="userPermissions{{ $index }}">
                                    <form action="{{ route('admin.permissions.update', $user) }}" method="POST" class="p-6 space-y-6">
                                        @csrf
                                        @method('PUT')

                                        @foreach($permissions as $group => $groupPermissions)
                                            <div class="mb-6">
                                                <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                                    @if($group === 'content')
                                                        📝 Konten
                                                    @elseif($group === 'master_data')
                                                        📊 Master Data
                                                    @elseif($group === 'users')
                                                        👥 Pengguna
                                                    @elseif($group === 'settings')
                                                        ⚙️ Pengaturan
                                                    @else
                                                        {{ ucfirst(str_replace('_', ' ', $group)) }}
                                                    @endif
                                                </h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                    @foreach($groupPermissions as $permission)
                                                        <label class="flex items-start p-3 border border-slate-200 rounded-lg hover:bg-white cursor-pointer bg-white">
                                                            <input type="checkbox" 
                                                                   name="permissions[]" 
                                                                   value="{{ $permission->id }}"
                                                                   {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}
                                                                   class="mt-1 rounded border-slate-300 text-nu-600 focus:ring-nu-500">
                                                            <div class="ml-3 flex-1">
                                                                <p class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</p>
                                                                @if($permission->description)
                                                                    <p class="text-xs text-gray-500 mt-1">{{ $permission->description }}</p>
                                                                @endif
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="flex justify-end pt-4 border-t border-slate-200">
                                            <button type="submit" class="bg-nu-600 text-white px-6 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                                                💾 Simpan Permission
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Empty State (when search returns no results) -->
            <div id="noResults" class="hidden text-center py-12 bg-white rounded-xl shadow-sm border border-slate-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <p class="mt-4 text-gray-500">Tidak ada user yang ditemukan</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500">Belum ada user yang bisa diatur permission-nya</p>
                    <p class="text-sm text-gray-400 mt-2">User dengan role superadmin tidak bisa diatur permission-nya</p>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Toggle user permissions accordion function
function toggleUserAccordion(index, buttonElement) {
    const permissionsDiv = document.getElementById('userPermissions' + index);
    const arrow = document.getElementById('arrow' + index);
    
    if (!permissionsDiv) {
        console.error('Permissions div not found for index:', index);
        return;
    }
    
    const isHidden = permissionsDiv.classList.contains('hidden');
    
    if (isHidden) {
        permissionsDiv.classList.remove('hidden');
        if (buttonElement) {
            buttonElement.setAttribute('aria-expanded', 'true');
        }
        if (arrow) {
            arrow.style.transform = 'rotate(180deg)';
        }
    } else {
        permissionsDiv.classList.add('hidden');
        if (buttonElement) {
            buttonElement.setAttribute('aria-expanded', 'false');
        }
        if (arrow) {
            arrow.style.transform = 'rotate(0deg)';
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Also add event listeners as backup
    document.querySelectorAll('.user-header').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const index = this.getAttribute('data-user-index');
            toggleUserAccordion(index, this);
        });
    });

    // Search functionality
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const userItems = document.querySelectorAll('.user-item');
            let visibleCount = 0;

            userItems.forEach(function(item) {
                const userName = item.getAttribute('data-user-name');
                const userEmail = item.getAttribute('data-user-email');
                
                if ((userName && userName.includes(searchTerm)) || 
                    (userEmail && userEmail.includes(searchTerm))) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            if (visibleCount === 0 && searchTerm !== '') {
                if (noResults) noResults.classList.remove('hidden');
            } else {
                if (noResults) noResults.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
@endsection
