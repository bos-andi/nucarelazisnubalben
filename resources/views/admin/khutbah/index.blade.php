@extends('layouts.admin')

@section('title', 'Kelola Khutbah Jum\'at')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Khutbah Jum'at</h1>
                <p class="text-slate-600 mt-1">Atur khutbah Jum'at yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.khutbah.create') }}" class="bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                Tambah Khutbah
            </a>
        </div>

        @if (session('status'))
            <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('status') }}</p>
            </div>
        @endif

        <div class="p-6">
            @if ($khutbahs->count() > 0)
                <div class="mb-4">
                    <form action="{{ route('admin.khutbah.index') }}" method="GET" class="flex gap-3">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari khutbah..." 
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-nu-500 focus:border-transparent">
                        <button type="submit" class="bg-nu-600 text-white px-6 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                            Cari
                        </button>
                        @if(request('q'))
                            <a href="{{ route('admin.khutbah.index') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors">
                                Reset
                            </a>
                        @endif
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
                                @if(auth()->user()->isSuperAdmin())
                                    <th class="text-left py-3 px-4 font-medium text-slate-700">Pembuat</th>
                                @endif
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Status</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($khutbahs as $khutbah)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4 text-slate-600">
                                        {{ $khutbah->khutbah_date->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-medium text-slate-900">{{ $khutbah->title }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        {{ $khutbah->khatib ?? '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        {{ $khutbah->location ?? '-' }}
                                    </td>
                                    @if(auth()->user()->isSuperAdmin())
                                        <td class="py-4 px-4 text-slate-600">
                                            {{ $khutbah->user->name ?? '-' }}
                                        </td>
                                    @endif
                                    <td class="py-4 px-4 text-center">
                                        @if ($khutbah->is_published)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Published</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Draft</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.khutbah.edit', $khutbah) }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.khutbah.destroy', $khutbah) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus khutbah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                                    Hapus
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
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="mt-4 text-slate-500">Belum ada khutbah yang ditambahkan</p>
                    <a href="{{ route('admin.khutbah.create') }}" class="mt-4 inline-block bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                        Tambah Khutbah Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

