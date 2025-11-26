@extends('layouts.admin')

@section('title', 'Kelola Program')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelola Program</h1>
                <p class="text-slate-600 mt-1">Atur program-program Lazisnu yang ditampilkan di halaman utama</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" class="bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                Tambah Program
            </a>
        </div>

        @if (session('status'))
            <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('status') }}</p>
            </div>
        @endif

        <div class="p-6">
            @if ($programs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Urutan</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Icon</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Judul</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-700">Deskripsi</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Status</th>
                                <th class="text-center py-3 px-4 font-medium text-slate-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4 text-slate-600">{{ $program->sort_order }}</td>
                                    <td class="py-4 px-4">
                                        @if ($program->icon)
                                            <span class="text-2xl">{{ $program->icon }}</span>
                                        @else
                                            <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-medium text-slate-900">{{ $program->title }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">
                                        {{ Str::limit($program->description, 80) }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if ($program->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.programs.edit', $program) }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <p class="mt-4 text-slate-500">Belum ada program yang ditambahkan</p>
                    <a href="{{ route('admin.programs.create') }}" class="mt-4 inline-block bg-nu-600 text-white px-4 py-2 rounded-lg hover:bg-nu-700 transition-colors">
                        Tambah Program Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

