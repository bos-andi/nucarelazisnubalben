@extends('layouts.admin')

@section('title', 'Edit Media Galeri - Lazisnu Balongbendo')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Galeri</p>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">Edit {{ $item->title }}</h1>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="text-sm font-semibold text-slate-500">Kembali</a>
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

        <form action="{{ route('admin.gallery.update', $item) }}" method="POST" enctype="multipart/form-data" class="mt-8 bg-white rounded-3xl shadow-lg border border-slate-100 p-8 space-y-6">
            @include('admin.gallery.form', ['item' => $item])
        </form>
    </div>
</div>
@endsection

