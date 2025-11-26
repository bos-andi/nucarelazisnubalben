@extends('layouts.admin')

@section('title', 'Dashboard - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Berita</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_articles']) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <span class="font-medium">+{{ $stats['published_articles'] }}</span> terpublikasi
                    </p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Featured Articles -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Berita Unggulan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['featured_articles']) }}</p>
                    <p class="text-sm text-orange-600 mt-1">
                        <span class="font-medium">{{ $stats['total_articles'] > 0 ? round(($stats['featured_articles'] / $stats['total_articles']) * 100, 1) : 0 }}%</span> dari total
                    </p>
                </div>
                <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Kategori</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_categories']) }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                        <span class="font-medium">{{ $stats['total_tags'] }}</span> tag tersedia
                    </p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Gallery -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Galeri</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_gallery']) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <span class="font-medium">{{ $stats['total_users'] }}</span> kontributor
                    </p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Statistics -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">📊 Statistik Pengunjung</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today Visitors -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pengunjung Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($visitor_stats['today_visitors']) }}</p>
                        <p class="text-sm text-blue-600 mt-1">
                            <span class="font-medium">{{ number_format($visitor_stats['today_unique_visitors']) }}</span> unik
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Month Visitors -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($visitor_stats['month_visitors']) }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-medium">{{ date('F Y') }}</span>
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Visitors -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pengunjung</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($visitor_stats['total_visitors']) }}</p>
                        <p class="text-sm text-purple-600 mt-1">
                            <span class="font-medium">Semua waktu</span>
                        </p>
                    </div>
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Device Stats -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Perangkat Populer</p>
                        @if(count($device_stats) > 0)
                            <p class="text-2xl font-bold text-gray-900 mt-2 capitalize">{{ $device_stats[0]['device_type'] ?? 'Desktop' }}</p>
                            <p class="text-sm text-orange-600 mt-1">
                                <span class="font-medium">{{ number_format($device_stats[0]['count'] ?? 0) }}</span> kunjungan
                            </p>
                        @else
                            <p class="text-2xl font-bold text-gray-900 mt-2">Desktop</p>
                            <p class="text-sm text-gray-400 mt-1">Belum ada data</p>
                        @endif
                    </div>
                    <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Statistik Berita</h3>
                        <p class="text-sm text-gray-600">Jumlah berita per bulan tahun {{ date('Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option>{{ date('Y') }}</option>
                        </select>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="articlesChart"></canvas>
                </div>
            </div>

            <!-- Visitor Chart -->
            <div class="bg-white rounded-xl p-6 card-shadow mt-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tren Pengunjung</h3>
                        <p class="text-sm text-gray-600">7 hari terakhir</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="space-y-6">
            <!-- Recent Articles Card -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Berita Terbaru</h3>
                    <a href="{{ route('admin.articles.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($recent_articles as $article)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            @if($article->cover_image)
                                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $article->title }}</p>
                            <p class="text-xs text-gray-500">{{ $article->category->name ?? 'Tanpa Kategori' }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $article->created_at->diffForHumans() }}</p>
                        </div>
                        @if($article->is_featured)
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Unggulan
                            </span>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada berita</p>
                        <a href="{{ route('admin.articles.create') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium mt-1 inline-block">Buat berita pertama</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Pages -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Halaman Populer</h3>
                    <span class="text-sm text-gray-500">Kunjungan</span>
                </div>
                <div class="space-y-3">
                    @forelse($top_pages as $page)
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $page['page_title'] ?? 'Halaman Website' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ parse_url($page['page_url'], PHP_URL_PATH) }}</p>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ number_format($page['visits']) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Belum ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Popular Categories -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Kategori Populer</h3>
                    @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.categories.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Kelola</a>
                    @endif
                </div>
                <div class="space-y-3">
                    @forelse($popular_categories as $category)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <span class="text-xs font-semibold text-white">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                                <p class="text-xs text-gray-500">{{ $category->articles_count }} berita</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['total_articles'] > 0 ? ($category->articles_count / $stats['total_articles']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">Belum ada kategori</p>
                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.categories.create') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium mt-1 inline-block">Buat kategori</a>
                        @endif
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.articles.create') }}" class="bg-white rounded-xl p-4 card-shadow hover:card-shadow-lg transition-shadow group">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Buat Berita</p>
                        <p class="text-xs text-gray-500">Tulis berita baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.gallery.create') }}" class="bg-white rounded-xl p-4 card-shadow hover:card-shadow-lg transition-shadow group">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Upload Galeri</p>
                        <p class="text-xs text-gray-500">Tambah foto/video</p>
                    </div>
                </div>
            </a>

            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.categories.create') }}" class="bg-white rounded-xl p-4 card-shadow hover:card-shadow-lg transition-shadow group">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Buat Kategori</p>
                        <p class="text-xs text-gray-500">Tambah kategori baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.tags.create') }}" class="bg-white rounded-xl p-4 card-shadow hover:card-shadow-lg transition-shadow group">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Buat Tag</p>
                        <p class="text-xs text-gray-500">Tambah tag baru</p>
                    </div>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart configuration
    const ctx = document.getElementById('articlesChart').getContext('2d');
    const chartData = @json($chart_data);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Berita',
                data: chartData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });

    // Visitors Chart
    const visitorCtx = document.getElementById('visitorsChart').getContext('2d');
    const visitorChartData = @json($visitor_chart_data);
    
    new Chart(visitorCtx, {
        type: 'bar',
        data: {
            labels: visitorChartData.map(item => item.day),
            datasets: [{
                label: 'Total Kunjungan',
                data: visitorChartData.map(item => item.visitors),
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: '#22c55e',
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
            }, {
                label: 'Pengunjung Unik',
                data: visitorChartData.map(item => item.unique_visitors),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#3b82f6',
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endsection

