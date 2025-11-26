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
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
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
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar overlay -->
        <div id="mobile-sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden md:hidden"></div>
        
        <!-- Sidebar -->
        <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto sidebar-gradient">
                <div class="flex items-center flex-shrink-0 px-6">
                    <div class="flex items-center gap-3">
                        <span class="h-10 w-10 rounded-xl bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-semibold text-sm shadow-lg">NU</span>
                        <div>
                            <p class="text-white font-semibold text-lg">Lazisnu</p>
                            <p class="text-slate-300 text-xs">Admin Dashboard</p>
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
                        
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Konten</p>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.articles.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    Berita
                                </a>
                                <a href="{{ route('admin.gallery.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.gallery.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Galeri
                                </a>
                            </div>
                        </div>

                        @if(auth()->user()->isSuperAdmin())
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Master Data</p>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Kategori
                                </a>
                                <a href="{{ route('admin.tags.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.tags.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Tag
                                </a>
                                <a href="{{ route('admin.programs.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.programs.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Program
                                </a>
                            </div>
                        </div>

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

                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan</p>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.settings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Website
                                </a>
                                <a href="{{ route('admin.adsense.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.adsense.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    AdSense
                                </a>
                                <a href="{{ route('admin.organization.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.organization.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Organisasi
                                </a>
                                <a href="{{ route('admin.contact.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contact.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"></path>
                                    </svg>
                                    Kontak
                                </a>
                                <a href="{{ route('admin.system-updates.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.system-updates.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    System Updates
                                </a>
                            </div>
                        </div>
                        @endif
                    </nav>
                    
                    <div class="flex-shrink-0 px-4 pb-4">
                        <div class="flex items-center px-3 py-2 text-sm text-slate-300">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="mr-3 h-8 w-8 rounded-full object-cover">
                            @else
                                <div class="mr-3 h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="font-medium text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.profile.show') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-lg hover:bg-white/5 hover:text-white">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('home') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-lg hover:bg-white/5 hover:text-white">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Lihat Website
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full group flex items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-lg hover:bg-white/5 hover:text-white">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top bar for mobile -->
            <div class="md:hidden bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="h-8 w-8 rounded-lg bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-semibold text-xs">NU</span>
                        <span class="font-semibold text-gray-900">Admin Dashboard</span>
                    </div>
                    <button id="mobile-menu-button" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-nu-500">
                        <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
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
            
            if (editorContainer && hiddenInput) {
                // Initialize Quill
                const quill = new Quill('#quill-editor', {
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
                                                    const range = quill.getSelection();
                                                    quill.insertEmbed(range.index, 'image', result.url);
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

                // Set initial content
                if (hiddenInput.value) {
                    quill.root.innerHTML = hiddenInput.value;
                }

                // Update hidden input on text change
                quill.on('text-change', function() {
                    hiddenInput.value = quill.root.innerHTML;
                });

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
</body>
</html>
