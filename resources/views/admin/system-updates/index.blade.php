@extends('layouts.admin')

@section('title', 'System Updates - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🚀 System Updates</h1>
                <p class="text-gray-600 mt-1">Kelola update website secara manual melalui Git repository</p>
            </div>
            @if($currentVersion)
                <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2">
                    <p class="text-xs text-blue-600 font-medium">Current Version</p>
                    <p class="text-lg font-bold text-blue-800">{{ $currentVersion->version_string }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <!-- Git Status -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Git Repository</p>
                    <p class="text-lg font-bold {{ $isGitRepo ? 'text-green-600' : 'text-red-600' }} mt-1">
                        {{ $isGitRepo ? 'Connected' : 'Not Connected' }}
                    </p>
                    @if($currentBranch)
                        <p class="text-xs text-gray-500 mt-1">Branch: {{ $currentBranch }}</p>
                    @endif
                </div>
                <div class="h-12 w-12 {{ $isGitRepo ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 {{ $isGitRepo ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Current Version -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Current Version</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $currentCommit ? substr($currentCommit, 0, 8) : 'Unknown' }}
                    </p>
                    @if($latestUpdate)
                        <p class="text-xs text-gray-500 mt-1">{{ $latestUpdate->completed_at->diffForHumans() }}</p>
                    @endif
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">System Status</p>
                    <p class="text-lg font-bold {{ $isUpdating ? 'text-orange-600' : 'text-green-600' }} mt-1">
                        {{ $isUpdating ? 'Updating...' : 'Ready' }}
                    </p>
                    @if($updateCheck && $updateCheck['success'] && $updateCheck['has_updates'])
                        <p class="text-xs text-orange-600 mt-1">Updates available</p>
                    @elseif($updateCheck && $updateCheck['success'])
                        <p class="text-xs text-green-600 mt-1">Up to date</p>
                    @endif
                </div>
                <div class="h-12 w-12 {{ $isUpdating ? 'bg-orange-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 {{ $isUpdating ? 'text-orange-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($isUpdating)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        @endif
                    </svg>
                </div>
            </div>
        </div>

        <!-- Available Updates -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Available Updates</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        @if($updateCheck && $updateCheck['success'])
                            {{ $updateCheck['has_updates'] ? count($updateCheck['changes']) : 0 }}
                        @else
                            -
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-1">New commits</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Update Actions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Update Actions</h3>
                
                @if(!$isGitRepo)
                    <!-- Git Setup -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-yellow-800 mb-2">Setup Git Repository</h4>
                        <p class="text-sm text-yellow-700 mb-4">Connect your website to a Git repository for automatic updates.</p>
                        
                        <form id="initRepoForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Repository URL</label>
                                <input type="url" name="repository_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="https://github.com/username/repository.git" required>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Initialize Repository
                            </button>
                        </form>
                    </div>
                @elseif(!$hasRemoteOrigin)
                    <!-- Remote Origin Setup -->
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-orange-800 mb-2">Add Remote Repository</h4>
                        <p class="text-sm text-orange-700 mb-4">Your Git repository is initialized but no remote origin is configured. Add a remote repository to enable updates.</p>
                        
                        <form id="addRemoteForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Repository URL</label>
                                <input type="url" name="repository_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="https://github.com/username/repository.git" required>
                            </div>
                            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                                Add Remote Origin
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Remote Origin Info -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-green-800 mb-2">Remote Repository</h4>
                        <p class="text-sm text-green-700 mb-2">Connected to: <code class="bg-green-100 px-2 py-1 rounded text-xs">{{ $remoteOriginUrl }}</code></p>
                        <p class="text-xs text-green-600">Repository is ready for automatic updates</p>
                    </div>
                @endif

                @if($isGitRepo)
                    <!-- Update Controls -->
                    <div class="space-y-4">
                        <!-- Check Updates -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900">Check for Updates</h4>
                                <p class="text-sm text-gray-600">Scan repository for new commits and changes</p>
                            </div>
                            <button id="checkUpdatesBtn" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                Check Updates
                            </button>
                        </div>

                        @if($updateCheck && $updateCheck['success'] && $updateCheck['has_updates'])
                            <!-- Available Changes (Info Only - No Auto Deploy) -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-medium text-blue-800 mb-2">Available Changes ({{ count($updateCheck['changes']) }} commits):</h4>
                                <p class="text-xs text-blue-600 mb-2">Gunakan "Manual Update Package" untuk update manual</p>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    @foreach($updateCheck['changes'] as $change)
                                        <li class="flex items-center">
                                            <svg class="h-4 w-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            {{ $change }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Rollback - DISABLED (Manual Update Only) --}}
                        {{-- 
                        @if($latestUpdate && $latestUpdate->status === 'completed')
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                                <div>
                                    <h4 class="font-medium text-red-800">Rollback</h4>
                                    <p class="text-sm text-red-600">Revert to previous version if needed</p>
                                </div>
                                <button id="rollbackBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors" {{ $isUpdating ? 'disabled' : '' }}>
                                    Rollback
                                </button>
                            </div>
                        @endif
                        --}}

                        <!-- Manual Update Package -->
                        <div class="space-y-4 mt-4">
                            <!-- Generate Package (for localhost) -->
                            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-200">
                                <div>
                                    <h4 class="font-medium text-purple-800">📦 Generate Update Package (Localhost)</h4>
                                    <p class="text-sm text-purple-600">Generate ZIP package dari localhost untuk di-upload ke hosting</p>
                                </div>
                                <div class="flex gap-2">
                                    <button id="previewFilesBtn" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors text-sm">
                                        Preview Files
                                    </button>
                                    <button id="generatePackageBtn" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                        Generate Package
                                    </button>
                                </div>
                            </div>

                            <!-- Upload Package (for hosting/VPS) -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="font-medium text-blue-800 mb-2">📤 Upload Update Package (Hosting/VPS)</h4>
                                <p class="text-sm text-blue-600 mb-4">Upload package ZIP yang sudah di-generate dari localhost</p>
                                
                                <form id="uploadPackageForm" enctype="multipart/form-data" class="space-y-3">
                                    <div>
                                        <input type="file" id="packageFile" name="package" accept=".zip" required 
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <p class="text-xs text-gray-500 mt-1">Format: update-package-*.zip (Max 100MB)</p>
                                    </div>
                                    <button type="submit" id="uploadPackageBtn" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                        Upload Package
                                    </button>
                                </form>

                                <!-- Upload Result -->
                                <div id="uploadResult" class="hidden mt-4 p-3 bg-white rounded border">
                                    <div id="uploadResultContent"></div>
                                    <button id="applyPackageBtn" class="hidden mt-3 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        Apply Update Package
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Files Modal -->
                        <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Files yang Akan Di-Update</h3>
                                    <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="previewContent" class="space-y-2">
                                    <p class="text-gray-600">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Update History -->
        <div class="space-y-6">
            <!-- Recent Updates -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Updates</h3>
                
                @if($updateHistory->count() > 0)
                    <div class="space-y-3">
                        @foreach($updateHistory as $update)
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    @if($update->status === 'completed')
                                        <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @elseif($update->status === 'failed')
                                        <div class="h-8 w-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    @elseif($update->status === 'in_progress')
                                        <div class="h-8 w-8 bg-orange-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-orange-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $update->description ?? 'System Update' }}</p>
                                    <p class="text-xs text-gray-500">{{ $update->updatedBy->name ?? 'System' }} • {{ $update->created_at->diffForHumans() }}</p>
                                    @if($update->commit_hash)
                                        <p class="text-xs text-gray-400 font-mono">{{ substr($update->commit_hash, 0, 8) }}</p>
                                    @endif
                                </div>
                                <div class="flex-shrink-0">
                                    <button onclick="viewLogs({{ $update->id }})" class="text-xs text-blue-600 hover:text-blue-700">
                                        View Logs
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">No updates yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Logs Modal -->
<div id="logsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[80vh] overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Update Logs</h3>
                <button onclick="closeLogs()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-96">
                <pre id="logsContent" class="text-sm text-gray-800 bg-gray-50 p-4 rounded-lg whitespace-pre-wrap"></pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize repository
    const initRepoForm = document.getElementById('initRepoForm');
    if (initRepoForm) {
        initRepoForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Initializing...';
            
            try {
                const response = await fetch('{{ route("admin.system-updates.init-repository") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Repository initialized successfully! Page will reload.');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    // Add remote origin
    const addRemoteForm = document.getElementById('addRemoteForm');
    if (addRemoteForm) {
        addRemoteForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Adding Remote...';
            
            try {
                const response = await fetch('{{ route("admin.system-updates.add-remote-origin") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Remote origin added successfully! Page will reload.');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }
    
    // Check updates
    const checkUpdatesBtn = document.getElementById('checkUpdatesBtn');
    if (checkUpdatesBtn) {
        checkUpdatesBtn.addEventListener('click', async function() {
            const originalText = this.textContent;
            this.disabled = true;
            this.textContent = 'Checking...';
            
            try {
                const response = await fetch('{{ route("admin.system-updates.check-updates") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    }
    
    // Deploy updates - DISABLED (Manual Update Only)
    // const deployBtn = document.getElementById('deployBtn');
    // if (deployBtn) {
    //     deployBtn.addEventListener('click', async function() {
    //         ...
    //     });
    // }
    
    // Rollback - DISABLED (Manual Update Only)
    // const rollbackBtn = document.getElementById('rollbackBtn');
    // if (rollbackBtn) {
    //     rollbackBtn.addEventListener('click', async function() {
    //         ... (disabled)
    //     });
    // }

    // Preview Files for Manual Update
    const previewFilesBtn = document.getElementById('previewFilesBtn');
    if (previewFilesBtn) {
        previewFilesBtn.addEventListener('click', async function() {
            const originalText = this.textContent;
            this.disabled = true;
            this.textContent = 'Loading...';
            
            try {
                const response = await fetch('{{ route("admin.system-updates.manual.changed-files") }}');
                const result = await response.json();
                
                if (result.success) {
                    const previewContent = document.getElementById('previewContent');
                    if (result.files && result.files.length > 0) {
                        let html = `<p class="text-sm text-gray-600 mb-4">Total: <strong>${result.count}</strong> files</p>`;
                        html += '<div class="space-y-1 max-h-96 overflow-y-auto">';
                        result.files.forEach(file => {
                            const category = getFileCategory(file);
                            html += `<div class="flex items-center text-sm p-2 bg-gray-50 rounded">
                                <span class="text-gray-500 mr-2">${category}</span>
                                <code class="text-xs">${file}</code>
                            </div>`;
                        });
                        html += '</div>';
                        previewContent.innerHTML = html;
                    } else {
                        previewContent.innerHTML = '<p class="text-gray-600">No files changed</p>';
                    }
                    document.getElementById('previewModal').classList.remove('hidden');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    }

    // Generate Manual Update Package
    const generatePackageBtn = document.getElementById('generatePackageBtn');
    if (generatePackageBtn) {
        generatePackageBtn.addEventListener('click', async function() {
            if (!confirm('Generate update package? This will create a ZIP file with all changed files.')) {
                return;
            }
            
            const originalText = this.textContent;
            this.disabled = true;
            this.textContent = 'Generating...';
            
            try {
                const response = await fetch('{{ route("admin.system-updates.manual.generate-package") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Download the package using query parameter
                    const encodedFilename = encodeURIComponent(result.filename);
                    const downloadUrl = `{{ route('admin.system-updates.manual.download') }}?file=${encodedFilename}`;
                    
                    // Create temporary link and click it
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = result.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    alert(`Package generated successfully!\nFiles: ${result.files_count}\nMigrations: ${result.migrations_count}\n\nDownload started.`);
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    }
});

// Helper function to categorize files
function getFileCategory(file) {
    if (file.includes('app/Http/Controllers')) return '🎮';
    if (file.includes('app/Models')) return '📊';
    if (file.includes('resources/views')) return '🎨';
    if (file.includes('routes/')) return '🛣️';
    if (file.includes('database/migrations')) return '🗄️';
    if (file.includes('config/')) return '⚙️';
    if (file.includes('public/') || file.includes('resources/')) return '📦';
    return '📄';
}

// Close preview modal
function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

// Upload Package Form
const uploadPackageForm = document.getElementById('uploadPackageForm');
if (uploadPackageForm) {
    uploadPackageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('packageFile');
        const uploadBtn = document.getElementById('uploadPackageBtn');
        const resultDiv = document.getElementById('uploadResult');
        const resultContent = document.getElementById('uploadResultContent');
        const applyBtn = document.getElementById('applyPackageBtn');
        
        if (!fileInput.files.length) {
            alert('Please select a package file');
            return;
        }
        
        const formData = new FormData();
        formData.append('package', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        const originalText = uploadBtn.textContent;
        uploadBtn.disabled = true;
        uploadBtn.textContent = 'Uploading...';
        resultDiv.classList.add('hidden');
        
        try {
            const response = await fetch('{{ route("admin.system-updates.manual.upload-package") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                resultContent.innerHTML = `
                    <div class="text-green-600 font-medium mb-2">✓ Package uploaded successfully!</div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Files:</strong> ${result.files_count}</p>
                        ${result.has_migrations ? '<p><strong>Migrations:</strong> Included</p>' : ''}
                    </div>
                `;
                resultDiv.classList.remove('hidden');
                applyBtn.classList.remove('hidden');
                applyBtn.dataset.filename = result.filename;
            } else {
                resultContent.innerHTML = `<div class="text-red-600">Error: ${result.message}</div>`;
                resultDiv.classList.remove('hidden');
            }
        } catch (error) {
            resultContent.innerHTML = `<div class="text-red-600">Error: ${error.message}</div>`;
            resultDiv.classList.remove('hidden');
        } finally {
            uploadBtn.disabled = false;
            uploadBtn.textContent = originalText;
        }
    });
}

// Apply Package
const applyPackageBtn = document.getElementById('applyPackageBtn');
if (applyPackageBtn) {
    applyPackageBtn.addEventListener('click', async function() {
        if (!confirm('Are you sure you want to apply this update package? This will update files and may run migrations.')) {
            return;
        }
        
        const filename = this.dataset.filename;
        if (!filename) {
            alert('Package filename not found');
            return;
        }
        
        const originalText = this.textContent;
        this.disabled = true;
        this.textContent = 'Applying...';
        
        try {
            const response = await fetch('{{ route("admin.system-updates.manual.apply-package") }}', {
                method: 'POST',
                body: JSON.stringify({
                    filename: filename
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert(`Update applied successfully!\n\nFiles extracted: ${result.files_extracted}\nMigrations: ${result.has_migrations ? 'Applied' : 'None'}\n\nPage will reload...`);
                window.location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Error: ' + error.message);
        } finally {
            this.disabled = false;
            this.textContent = originalText;
        }
    });
}

// View logs function
async function viewLogs(updateId) {
    try {
        const response = await fetch(`/dashboard/system-updates/${updateId}/logs`);
        const result = await response.json();
        
        if (result.success) {
            document.getElementById('logsContent').textContent = result.logs || 'No logs available';
            document.getElementById('logsModal').classList.remove('hidden');
        } else {
            alert('Error loading logs');
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}

// Close logs modal
function closeLogs() {
    document.getElementById('logsModal').classList.add('hidden');
}
</script>
@endsection
