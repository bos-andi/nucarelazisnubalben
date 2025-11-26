@extends('layouts.admin')

@section('title', 'Edit Kategori - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Ubah Kategori</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">{{ $category->name }}</h1>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-slate-500">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="mt-6 p-4 border border-red-200 rounded-2xl bg-red-50 text-red-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 p-8">
            @include('admin.categories.form', ['category' => $category])
        </form>
    </div>
</div>
@endsection

