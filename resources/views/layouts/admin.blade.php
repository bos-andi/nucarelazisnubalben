<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Lazisnu Balongbendo')</title>
    
    @if(\App\Models\SiteSetting::get('site_favicon'))
        <link rel="icon" type="image/png" href="{{ \App\Models\SiteSetting::get('site_favicon') }}">
        <link rel="shortcut icon" type="image/png" href="{{ \App\Models\SiteSetting::get('site_favicon') }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        /* Editable Image Wrapper Styles */
        .ql-image-editable-wrapper {
            transition: box-shadow 0.2s;
        }
        .ql-image-editable-wrapper:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .ql-image-resize-handle {
            visibility: visible !important;
            opacity: 1 !important;
            display: flex !important;
        }
        .ql-image-resize-handle:hover {
            background: #047857 !important;
            transform: scale(1.15) !important;
        }
        .ql-image-resize-handle:active {
            background: #065f46 !important;
            transform: scale(1.1) !important;
        }
        /* Ensure handle is always visible on selected image */
        .ql-image-editable-wrapper.selected .ql-image-resize-handle {
            visibility: visible !important;
            opacity: 1 !important;
            display: flex !important;
        }
        .ql-editor .ql-image-editable-wrapper img {
            border-radius: 4px;
        }
        .ql-image-control-panel button:hover {
            transform: scale(1.1);
        }
        .ql-image-control-panel button:active {
            transform: scale(0.95);
        }
        .ql-image-editable-wrapper:hover .ql-image-control-panel {
            display: flex !important;
        }
        .ql-image-control-panel {
            opacity: 1 !important;
            pointer-events: all !important;
            display: flex !important;
        }
        /* Make control panel always visible */
        .ql-image-editable-wrapper .ql-image-control-panel {
            opacity: 1 !important;
            pointer-events: all !important;
        }
        /* Selection border when image is clicked */
        .ql-image-editable-wrapper.selected {
            outline: 2px solid #059669;
            outline-offset: 2px;
        }
        .ql-image-editable-wrapper.selected img {
            outline: 1px dashed #059669;
        }
        /* Resize handle hover effects */
        .ql-image-resize-handle:hover {
            background: #047857 !important;
            transform: scale(1.2);
        }
        .ql-image-resize-handle:active {
            background: #065f46 !important;
            transform: scale(1.1);
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        nu: {
                            50: '#ecfdf3',
                            100: '#d1fadf',
                            200: '#a7f3c7',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        .card-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .card-shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
@php
    // Load user permissions for menu display
    if (auth()->check()) {
        auth()->user()->load('permissions');
    }
@endphp
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar overlay -->
        <div id="mobile-sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden md:hidden"></div>
        
        <!-- Sidebar -->
        <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto sidebar-gradient">
                <div class="flex items-center flex-shrink-0 px-6 py-4">
                    <div class="flex items-center justify-between w-full gap-3">
                        <!-- Profile Photo with Dropdown (replaces NU icon) -->
                        <div class="relative flex items-center gap-3 flex-1" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-xl object-cover border-2 border-white/20 hover:border-white/40 transition-colors shadow-lg">
                                @else
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-semibold border-2 border-white/20 hover:border-white/40 transition-colors shadow-lg">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-semibold text-lg">{{ auth()->user()->name }}</p>
                                    @if(auth()->user()->isSuperAdmin())
                                        <!-- Superadmin Badge -->
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif(auth()->user()->isContributor() && auth()->user()->hasVerifiedKtp())
                                        <!-- Verified Contributor Badge -->
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-slate-300 text-xs">
                                    @if(auth()->user()->role === 'superadmin')
                                        Superadmin
                                    @elseif(auth()->user()->role === 'contributor')
                                        Kontributor
                                    @else
                                        {{ ucfirst(auth()->user()->role) }}
                                    @endif
                                </p>
                            </div>
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-0 top-full mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-[60]" style="display: none;">
                                <div class="py-1">
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                            @if(auth()->user()->isSuperAdmin())
                                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif(auth()->user()->isContributor() && auth()->user()->hasVerifiedKtp())
                                                <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            @if(auth()->user()->role === 'superadmin')
                                                Superadmin
                                            @elseif(auth()->user()->role === 'contributor')
                                                Kontributor
                                            @else
                                                {{ ucfirst(auth()->user()->role) }}
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('admin.profile.show') }}#password" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                        Ganti Password
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex-1 flex flex-col">
                    <nav class="flex-1 px-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['manage_articles', 'manage_gallery', 'manage_khutbah']))
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Konten</p>
                            <div class="mt-2 space-y-1">
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_articles'))
                                <a href="{{ route('admin.articles.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    Berita
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_gallery'))
                                <a href="{{ route('admin.gallery.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.gallery.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Galeri
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_khutbah'))
                                <a href="{{ route('admin.khutbah.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.khutbah.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Khutbah Jum'at
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['manage_categories', 'manage_tags', 'manage_programs']))
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Master Data</p>
                            <div class="mt-2 space-y-1">
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_categories'))
                                <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Kategori
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_tags'))
                                <a href="{{ route('admin.tags.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.tags.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Tag
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_programs'))
                                <a href="{{ route('admin.programs.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.programs.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Program
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isSuperAdmin())
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengguna</p>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.contributors.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contributors.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Kontributor
                                </a>
                            </div>
                        </div>
                        @endif

                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['manage_settings', 'manage_adsense', 'manage_organization', 'manage_contact', 'manage_system_updates']))
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan</p>
                            <div class="mt-2 space-y-1">
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_settings'))
                                <a href="{{ route('admin.settings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Website
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_adsense'))
                                <a href="{{ route('admin.adsense.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.adsense.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    AdSense
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_organization'))
                                <a href="{{ route('admin.organization.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.organization.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Organisasi
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_contact'))
                                <a href="{{ route('admin.contact.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contact.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"></path>
                                    </svg>
                                    Kontak
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('manage_system_updates'))
                                <a href="{{ route('admin.system-updates.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.system-updates.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    System Updates
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </nav>
                    
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top bar -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 py-3 flex items-center justify-between">
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center gap-3">
                        <span class="h-8 w-8 rounded-lg bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-semibold text-xs">NU</span>
                        <span class="font-semibold text-gray-900">Admin Dashboard</span>
                    </div>
                    <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-nu-500">
                        <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <!-- Top bar actions (Desktop) -->
                    <div class="hidden md:flex items-center gap-3 ml-auto">
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-nu-600 hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Lihat Website
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                @if (session('status'))
                    <div class="bg-nu-600 text-white text-center py-3 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            function toggleMobileMenu() {
                const isOpen = mobileSidebar.classList.contains('translate-x-0');
                
                if (isOpen) {
                    // Close menu
                    mobileSidebar.classList.remove('translate-x-0');
                    mobileSidebar.classList.add('-translate-x-full');
                    mobileSidebarOverlay.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    // Open menu
                    mobileSidebar.classList.remove('-translate-x-full');
                    mobileSidebar.classList.add('translate-x-0');
                    mobileSidebarOverlay.classList.remove('hidden');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            }
            
            // Toggle menu on button click
            mobileMenuButton?.addEventListener('click', toggleMobileMenu);
            
            // Close menu when clicking overlay
            mobileSidebarOverlay?.addEventListener('click', toggleMobileMenu);
            
            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileSidebar.classList.contains('translate-x-0')) {
                    toggleMobileMenu();
                }
            });
        });

        // Initialize Quill Editor
        document.addEventListener('DOMContentLoaded', function() {
            const editorContainer = document.getElementById('quill-editor');
            const hiddenInput = document.getElementById('body-input');
            let quill; // Declare quill variable in outer scope
            
            if (editorContainer && hiddenInput) {
                // Function to make image editable (without wrapping, using overlay approach)
                function makeImageEditable(img) {
                    // Skip if already processed or if image is not in the editor
                    if (!img) {
                        return;
                    }
                    if (!quill || !quill.root.contains(img)) {
                        return;
                    }
                    if (img.dataset.editable === 'true') {
                        return;
                    }
                    
                    img.dataset.editable = 'true';
                    
                    try {
                        // Store original dimensions (use naturalWidth if available, otherwise current size)
                        let originalWidth = img.naturalWidth || img.offsetWidth || 200;
                        let originalHeight = img.naturalHeight || img.offsetHeight || 150;
                        
                        // Wait for image to fully load to get accurate dimensions
                        if (!img.complete || img.naturalWidth === 0) {
                            img.onload = function() {
                                originalWidth = img.naturalWidth || img.offsetWidth;
                                originalHeight = img.naturalHeight || img.offsetHeight;
                                
                                // Auto-scale if too large
                                if (originalWidth > 800) {
                                    const scale = 800 / originalWidth;
                                    img.style.width = (originalWidth * scale) + 'px';
                                    img.style.height = (originalHeight * scale) + 'px';
                                }
                            };
                        }
                        
                        // Make image position relative and add styles
                        img.style.position = 'relative';
                        img.style.display = 'inline-block';
                        img.style.margin = '10px';
                        img.style.cursor = 'default';
                        img.style.userSelect = 'none';
                        img.draggable = false;
                        img.style.maxWidth = 'none';
                        img.style.minWidth = 'none';
                        img.style.height = 'auto';
                        
                        // If image is too large, scale it down initially
                        const currentWidth = img.offsetWidth || img.naturalWidth || originalWidth;
                        if (currentWidth > 800) {
                            const scale = 800 / currentWidth;
                            const currentHeight = img.offsetHeight || img.naturalHeight || originalHeight;
                            img.style.width = (currentWidth * scale) + 'px';
                            img.style.height = (currentHeight * scale) + 'px';
                            originalWidth = currentWidth * scale;
                            originalHeight = currentHeight * scale;
                        }
                        
                        // Create wrapper that contains both image and controls
                        // We'll use a span wrapper that Quill allows
                        const wrapper = document.createElement('span');
                        wrapper.className = 'ql-image-editable-wrapper';
                        wrapper.style.cssText = 'position: relative; display: inline-block; margin: 10px; vertical-align: middle; outline: none;';
                        
                        // Get parent and insert wrapper
                        const parent = img.parentNode;
                        if (parent) {
                            // Move image into wrapper
                            parent.insertBefore(wrapper, img);
                            wrapper.appendChild(img);
                            
                            // Control panel for zoom in/out (always visible)
                            const controlPanel = document.createElement('div');
                            controlPanel.className = 'ql-image-control-panel';
                            controlPanel.style.cssText = 'position: absolute; top: -45px; right: 0; background: #000; border-radius: 8px; padding: 8px; display: flex !important; gap: 8px; z-index: 9999 !important; opacity: 1 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.5); pointer-events: all !important; visibility: visible !important;';
                            console.log('Control panel created');
                            
                            // Zoom out button
                            const zoomOutBtn = document.createElement('button');
                            zoomOutBtn.innerHTML = '−';
                            zoomOutBtn.className = 'ql-image-zoom-out';
                            zoomOutBtn.style.cssText = 'width: 28px; height: 28px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 18px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: background 0.2s;';
                            zoomOutBtn.title = 'Perkecil gambar';
                            
                            // Zoom in button
                            const zoomInBtn = document.createElement('button');
                            zoomInBtn.innerHTML = '+';
                            zoomInBtn.className = 'ql-image-zoom-in';
                            zoomInBtn.style.cssText = 'width: 32px; height: 32px; background: #059669; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: all 0.2s;';
                            zoomInBtn.title = 'Perbesarkan gambar (20% per klik)';
                            
                            // Size display
                            const sizeDisplay = document.createElement('div');
                            sizeDisplay.className = 'ql-image-size-display';
                            sizeDisplay.style.cssText = 'min-width: 80px; height: 28px; background: rgba(255,255,255,0.2); color: white; padding: 0 8px; font-size: 11px; border-radius: 4px; display: flex; align-items: center; justify-content: center; white-space: nowrap;';
                            
                            // Simple resize handle at bottom-right corner (like Word)
                            const resizeHandle = document.createElement('div');
                            resizeHandle.className = 'ql-image-resize-handle';
                            resizeHandle.innerHTML = '◢';
                            resizeHandle.style.cssText = 'position: absolute; bottom: -12px; right: -12px; width: 24px; height: 24px; background: #059669; color: white; cursor: nwse-resize; border: 2px solid white; border-radius: 3px; z-index: 10000; box-shadow: 0 2px 8px rgba(0,0,0,0.4); pointer-events: all; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;';
                            resizeHandle.title = 'Klik dan seret untuk mengubah ukuran';
                            
                            controlPanel.appendChild(zoomOutBtn);
                            controlPanel.appendChild(sizeDisplay);
                            controlPanel.appendChild(zoomInBtn);
                            
                            wrapper.appendChild(controlPanel);
                            wrapper.appendChild(resizeHandle);
                            
                            // Test: Make handle very visible
                            setTimeout(() => {
                                resizeHandle.style.background = '#059669';
                                resizeHandle.style.visibility = 'visible';
                                resizeHandle.style.opacity = '1';
                                resizeHandle.style.display = 'flex';
                                console.log('Handle should be visible now');
                            }, 100);
                            
                            // Add selection border when image is clicked
                            img.addEventListener('click', function(e) {
                                e.stopPropagation();
                                // Remove selection from other images
                                document.querySelectorAll('.ql-image-editable-wrapper').forEach(w => {
                                    w.classList.remove('selected');
                                });
                                // Add selection to this image
                                wrapper.classList.add('selected');
                            });
                            
                            // Update original dimensions when image loads
                            if (!img.complete || img.naturalWidth === 0) {
                                img.onload = function() {
                                    const natWidth = img.naturalWidth || img.offsetWidth;
                                    const natHeight = img.naturalHeight || img.offsetHeight;
                                    img.dataset.originalWidth = natWidth;
                                    img.dataset.originalHeight = natHeight;
                                };
                            }
                            
                            // Add resize functionality to handle
                            setupResizeHandle(img, resizeHandle, sizeDisplay, originalWidth, originalHeight);
                            
                            console.log('Control panel added to wrapper');
                            console.log('Control panel element:', controlPanel);
                            console.log('Control panel computed style:', window.getComputedStyle(controlPanel));
                            
                            // Force control panel to be visible immediately
                            controlPanel.style.setProperty('opacity', '1', 'important');
                            controlPanel.style.setProperty('display', 'flex', 'important');
                            controlPanel.style.setProperty('pointer-events', 'all', 'important');
                            controlPanel.style.setProperty('visibility', 'visible', 'important');
                            
                            // Also try after a short delay
                            setTimeout(() => {
                                controlPanel.style.setProperty('opacity', '1', 'important');
                                controlPanel.style.setProperty('display', 'flex', 'important');
                                controlPanel.style.setProperty('pointer-events', 'all', 'important');
                                controlPanel.style.setProperty('visibility', 'visible', 'important');
                                console.log('Control panel forced visible');
                            }, 100);
                            
                            // Update size display initially (wait for image to load)
                            setTimeout(() => {
                                updateSizeDisplay(sizeDisplay, img.offsetWidth || img.naturalWidth || 200, img.offsetHeight || img.naturalHeight || 150);
                            }, 100);
                            
                            // Add zoom functionality
                            addZoomControls(img, zoomInBtn, zoomOutBtn, sizeDisplay);
                            
                            // Initialize drag
                            makeImageDraggableDirect(wrapper, img);
                        }
                    } catch (e) {
                        console.error('Error making image editable:', e);
                        img.dataset.editable = 'false';
                    }
                }
                
                // Alias for backward compatibility
                function wrapImageWithEditable(img) {
                    makeImageEditable(img);
                }

                // Make image draggable
                function makeImageDraggable(wrapper) {
                    let isDragging = false;
                    let startX, startY, startLeft, startTop;
                    
                    wrapper.addEventListener('mousedown', function(e) {
                        // Don't start drag if clicking on resize handle
                        if (e.target.classList.contains('ql-image-resize-handle')) {
                            return;
                        }
                        
                        if (e.target === wrapper.querySelector('img') || e.target === wrapper) {
                            isDragging = true;
                            wrapper.style.cursor = 'grabbing';
                            
                            const rect = wrapper.getBoundingClientRect();
                            const editorRect = editorContainer.getBoundingClientRect();
                            startX = e.clientX;
                            startY = e.clientY;
                            
                            // Get current position relative to editor
                            const computedStyle = window.getComputedStyle(wrapper);
                            startLeft = parseFloat(computedStyle.left) || (rect.left - editorRect.left);
                            startTop = parseFloat(computedStyle.top) || (rect.top - editorRect.top);
                            
                            if (computedStyle.position !== 'absolute') {
                                wrapper.style.position = 'absolute';
                            }
                            wrapper.style.zIndex = '1000';
                            
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    });
                    
                    document.addEventListener('mousemove', function(e) {
                        if (isDragging) {
                            const deltaX = e.clientX - startX;
                            const deltaY = e.clientY - startY;
                            
                            wrapper.style.left = (startLeft + deltaX) + 'px';
                            wrapper.style.top = (startTop + deltaY) + 'px';
                            
                            e.preventDefault();
                        }
                    });
                    
                    document.addEventListener('mouseup', function() {
                        if (isDragging) {
                            isDragging = false;
                            wrapper.style.cursor = 'move';
                            wrapper.style.zIndex = '1';
                            
                            // Update hidden input
                            if (quill) {
                                hiddenInput.value = quill.root.innerHTML;
                            }
                        }
                    });
                }

                // Setup resize handle (simple and reliable)
                function setupResizeHandle(img, handle, sizeDisplay, originalWidth, originalHeight) {
                    let isResizing = false;
                    let startX, startY, startWidth, startHeight;
                    
                    const wrapper = img.closest('.ql-image-editable-wrapper');
                    const controlPanel = wrapper?.querySelector('.ql-image-control-panel');
                    const displayElement = controlPanel?.querySelector('.ql-image-size-display') || sizeDisplay;
                    
                    // Mouse down on handle
                    handle.onmousedown = function(e) {
                        console.log('Resize handle clicked!');
                        e.preventDefault();
                        e.stopPropagation();
                        
                        isResizing = true;
                        const rect = img.getBoundingClientRect();
                        startX = e.clientX;
                        startY = e.clientY;
                        startWidth = rect.width;
                        startHeight = rect.height;
                        
                        console.log('Starting resize:', startWidth, 'x', startHeight);
                        
                        document.body.style.cursor = 'nwse-resize';
                        document.body.style.userSelect = 'none';
                        
                        if (displayElement) {
                            displayElement.style.display = 'flex';
                        }
                    };
                    
                    // Mouse move
                    document.onmousemove = function(e) {
                        if (!isResizing) return;
                        
                        const deltaX = e.clientX - startX;
                        const deltaY = e.clientY - startY;
                        
                        // Calculate new dimensions (can be smaller or larger)
                        let newWidth = startWidth + deltaX;
                        let newHeight = startHeight + deltaY;
                        
                        // Minimum size (very small, so user can shrink significantly)
                        if (newWidth < 30) newWidth = 30;
                        if (newHeight < 30) newHeight = 30;
                        
                        // Maintain aspect ratio
                        const aspectRatio = startWidth / startHeight;
                        const finalWidth = newWidth;
                        const finalHeight = finalWidth / aspectRatio;
                        
                        // Apply new size
                        img.style.width = finalWidth + 'px';
                        img.style.height = finalHeight + 'px';
                        img.style.maxWidth = 'none';
                        img.style.minWidth = 'none';
                        
                        if (displayElement) {
                            updateSizeDisplay(displayElement, finalWidth, finalHeight);
                        }
                    };
                    
                    // Mouse up
                    document.onmouseup = function() {
                        if (isResizing) {
                            isResizing = false;
                            document.body.style.cursor = '';
                            document.body.style.userSelect = '';
                            
                            if (quill) {
                                hiddenInput.value = quill.root.innerHTML;
                            }
                        }
                    };
                    
                    // Hover effects
                    handle.onmouseenter = function() {
                        this.style.background = '#047857';
                    };
                    
                    handle.onmouseleave = function() {
                        if (!isResizing) {
                            this.style.background = '#059669';
                        }
                    };
                }

                // Update size display
                function updateSizeDisplay(display, width, height) {
                    if (display) {
                        display.textContent = Math.round(width) + ' × ' + Math.round(height) + 'px';
                    }
                }
                
                // Add zoom controls (zoom in/out buttons)
                function addZoomControls(img, zoomInBtn, zoomOutBtn, sizeDisplay) {
                    const zoomStep = 0.2; // 20% per click (lebih besar untuk lebih mudah)
                    const minScale = 0.1; // Minimum 10% of original size (bisa sangat kecil)
                    const maxScale = 5.0; // Maximum 500% of original size
                    
                    // Store original dimensions
                    let originalWidth = img.naturalWidth || img.offsetWidth || 200;
                    let originalHeight = img.naturalHeight || img.offsetHeight || 150;
                    
                    // Wait for image to load
                    if (!img.complete || img.naturalWidth === 0) {
                        img.onload = function() {
                            originalWidth = img.naturalWidth || img.offsetWidth;
                            originalHeight = img.naturalHeight || img.offsetHeight;
                        };
                    }
                    
                    // Also try to get dimensions after a delay
                    setTimeout(() => {
                        if (img.naturalWidth > 0) {
                            originalWidth = img.naturalWidth;
                            originalHeight = img.naturalHeight;
                        } else {
                            // Use current displayed size as original if naturalWidth not available
                            originalWidth = img.offsetWidth || 200;
                            originalHeight = img.offsetHeight || 150;
                        }
                    }, 500);
                    
                    // Simple zoom functions - work with current size
                    function zoomIn() {
                        const currentWidth = parseFloat(img.style.width) || img.offsetWidth || 200;
                        const currentHeight = parseFloat(img.style.height) || img.offsetHeight || 150;
                        const newWidth = currentWidth * 1.2; // Increase 20%
                        const newHeight = currentHeight * 1.2;
                        
                        img.style.width = newWidth + 'px';
                        img.style.height = newHeight + 'px';
                        img.style.maxWidth = 'none';
                        img.style.minWidth = 'none';
                        
                        updateSizeDisplay(sizeDisplay, newWidth, newHeight);
                        
                        if (quill) {
                            hiddenInput.value = quill.root.innerHTML;
                        }
                    }
                    
                    function zoomOut() {
                        const currentWidth = parseFloat(img.style.width) || img.offsetWidth || 200;
                        const currentHeight = parseFloat(img.style.height) || img.offsetHeight || 150;
                        const newWidth = Math.max(30, currentWidth * 0.8); // Decrease 20%, minimum 30px
                        const newHeight = Math.max(30, currentHeight * 0.8);
                        
                        img.style.width = newWidth + 'px';
                        img.style.height = newHeight + 'px';
                        img.style.maxWidth = 'none';
                        img.style.minWidth = 'none';
                        
                        updateSizeDisplay(sizeDisplay, newWidth, newHeight);
                        
                        if (quill) {
                            hiddenInput.value = quill.root.innerHTML;
                        }
                    }
                    
                    // Zoom in
                    zoomInBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        zoomIn();
                    });
                    
                    // Zoom out
                    zoomOutBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        zoomOut();
                    });
                    
                    // Hover effects
                    zoomInBtn.addEventListener('mouseenter', function() {
                        this.style.background = '#047857';
                    });
                    zoomInBtn.addEventListener('mouseleave', function() {
                        this.style.background = '#059669';
                    });
                    
                    zoomOutBtn.addEventListener('mouseenter', function() {
                        this.style.background = '#dc2626';
                    });
                    zoomOutBtn.addEventListener('mouseleave', function() {
                        this.style.background = '#ef4444';
                    });
                }

                // Initialize existing images in editor
                function initializeExistingImages() {
                    const images = quill.root.querySelectorAll('img');
                    console.log('=== Initializing images ===');
                    console.log('Found images:', images.length);
                    images.forEach((img, index) => {
                        if (!img.dataset.editable) {
                            console.log(`Processing image ${index + 1}:`, img.src);
                            makeImageEditable(img);
                            // Check if handle was created
                            setTimeout(() => {
                                const wrapper = img.closest('.ql-image-editable-wrapper');
                                if (wrapper) {
                                    const handle = wrapper.querySelector('.ql-image-resize-handle');
                                    console.log(`Image ${index + 1} handle:`, handle ? 'CREATED' : 'NOT FOUND');
                                    if (handle) {
                                        console.log('Handle style:', window.getComputedStyle(handle).visibility);
                                    }
                                }
                            }, 200);
                        } else {
                            console.log(`Image ${index + 1} already editable`);
                        }
                    });
                }

                // MutationObserver to watch for new images
                let imageObserver = null;
                
                // Initialize Quill
                quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: {
                            container: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'align': [] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['blockquote', 'code-block'],
                                ['link', 'image'],
                                ['clean']
                            ],
                            handlers: {
                                image: function() {
                                    const input = document.createElement('input');
                                    input.setAttribute('type', 'file');
                                    input.setAttribute('accept', 'image/*');
                                    input.click();

                                    input.onchange = () => {
                                        const file = input.files[0];
                                        if (file) {
                                            const formData = new FormData();
                                            formData.append('image', file);
                                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                                            fetch('/admin/upload-image', {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(response => response.json())
                                            .then(result => {
                                                if (result.success) {
                                                    // Get current selection or set to end
                                                    let range = quill.getSelection(true);
                                                    if (!range) {
                                                        const length = quill.getLength();
                                                        range = { index: length - 1, length: 0 };
                                                    }
                                                    
                                                    // Insert image using Quill's standard method
                                                    quill.insertEmbed(range.index, 'image', result.url, 'user');
                                                    
                                                    // Wait for image to load and then make editable
                                                    const checkAndMakeEditable = (attempts = 0) => {
                                                        if (attempts > 15) return; // Max 15 attempts
                                                        
                                                        const images = quill.root.querySelectorAll('img');
                                                        let targetImage = null;
                                                        
                                                        // Find the newly inserted image by checking the last few images
                                                        for (let i = images.length - 1; i >= Math.max(0, images.length - 3); i--) {
                                                            const img = images[i];
                                                            if (!img.dataset.editable) {
                                                                const imgSrc = img.src || img.getAttribute('src') || '';
                                                                const resultUrl = result.url;
                                                                
                                                                // Check if image is loaded and URL matches
                                                                if (img.complete && img.naturalHeight !== 0) {
                                                                    // Check various URL formats
                                                                    if (imgSrc === resultUrl || 
                                                                        imgSrc.includes(resultUrl.split('/').pop()) ||
                                                                        resultUrl.includes(imgSrc.split('/').pop()) ||
                                                                        imgSrc.endsWith(resultUrl.split('/').pop()) ||
                                                                        resultUrl.endsWith(imgSrc.split('/').pop())) {
                                                                        targetImage = img;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        
                                                        if (targetImage) {
                                                            makeImageEditable(targetImage);
                                                        } else {
                                                            // Retry after 100ms
                                                            setTimeout(() => checkAndMakeEditable(attempts + 1), 100);
                                                        }
                                                    };
                                                    
                                                    // Start checking after a short delay
                                                    setTimeout(() => checkAndMakeEditable(), 300);
                                                } else {
                                                    alert('Upload failed: ' + result.message);
                                                }
                                            })
                                            .catch(error => {
                                                alert('Upload failed: ' + error.message);
                                            });
                                        }
                                    };
                                }
                            }
                        }
                    }
                });

                // Set up MutationObserver to watch for new images
                imageObserver = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) { // Element node
                                // Check if the added node is an image
                                if (node.tagName === 'IMG' && !node.dataset.editable) {
                                    setTimeout(() => makeImageEditable(node), 150);
                                }
                                // Check for images inside the added node
                                const images = node.querySelectorAll && node.querySelectorAll('img');
                                if (images) {
                                    images.forEach(img => {
                                        if (!img.dataset.editable) {
                                            setTimeout(() => makeImageEditable(img), 150);
                                        }
                                    });
                                }
                            }
                        });
                    });
                });
                
                // Start observing
                imageObserver.observe(quill.root, {
                    childList: true,
                    subtree: true
                });

                // Set initial content
                if (hiddenInput.value) {
                    quill.root.innerHTML = hiddenInput.value;
                    // Initialize existing images after content is loaded
                    setTimeout(initializeExistingImages, 200);
                }

                // Update hidden input on text change
                quill.on('text-change', function() {
                    hiddenInput.value = quill.root.innerHTML;
                });
                
                // Initialize images when editor is ready
                setTimeout(initializeExistingImages, 500);

                // Update on form submit
                const form = editorContainer.closest('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        hiddenInput.value = quill.root.innerHTML;
                    });
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>

