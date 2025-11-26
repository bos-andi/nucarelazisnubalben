@extends('layouts.app')

@section('title', $organizationStructure->title ?? 'Struktur Organisasi Lazisnu Balongbendo')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white">
        <div class="max-w-5xl mx-auto px-6 py-12 text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Struktur Organisasi</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">
                {{ $organizationStructure->title ?? 'Pengurus Lazisnu MWC NU Balongbendo 2024-2028' }}
            </h1>
            <p class="text-nu-100 mt-4">
                {{ $organizationStructure->content ?? 'Tim kolaboratif yang mengawal tata kelola ZIS, inovasi program sosial, serta transformasi digital di tingkat MWC.' }}
            </p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-6 -mt-12 relative bg-white rounded-[32px] shadow-2xl border border-slate-100 p-10 space-y-10">
        @if($organizationStructure && $organizationStructure->data && isset($organizationStructure->data['positions']) && count($organizationStructure->data['positions']) > 0)
            <!-- Dynamic Organization Structure -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($organizationStructure->data['positions'] as $position)
                    <div class="rounded-3xl border border-slate-100 bg-gradient-to-br from-white to-nu-50/40 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <!-- Photo -->
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-nu-200 shadow-sm">
                                <img src="{{ \App\Models\OrganizationSetting::getPositionPhoto($position['photo'] ?? null) }}" 
                                     alt="{{ $position['name'] }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <!-- Position Info -->
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold mb-2">
                                {{ $position['title'] }}
                                @if(isset($position['is_chairman']) && $position['is_chairman'])
                                    <span class="inline-block w-2 h-2 bg-nu-600 rounded-full ml-1"></span>
                                @endif
                            </p>
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $position['name'] }}</h3>
                            @if(!empty($position['description']))
                                <p class="text-sm text-slate-600">{{ $position['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Fallback Static Structure -->
            @php
                $struktur = [
                    ['posisi' => 'Pelindung', 'nama' => 'KH. Hasyim Arif (Rais Syuriah MWC)'],
                    ['posisi' => 'Penasehat', 'nama' => 'Hj. Siti Nur Azizah (Ketua Muslimat)'],
                    ['posisi' => 'Ketua', 'nama' => 'H. Ahmad Syamsudin'],
                    ['posisi' => 'Wakil Ketua', 'nama' => 'Ahmad Fauzi, S.Pd.I'],
                    ['posisi' => 'Sekretaris', 'nama' => 'Nurul Faizah'],
                    ['posisi' => 'Bendahara', 'nama' => 'Muhammad Ridwan'],
                    ['posisi' => 'Divisi Program Sosial', 'nama' => 'M. Choirul Anam'],
                    ['posisi' => 'Divisi Pendidikan & Khutbah', 'nama' => 'Ust. Fajar Kurniawan'],
                    ['posisi' => 'Divisi Kesehatan & Respon Bencana', 'nama' => 'dr. Dina Lestari'],
                    ['posisi' => 'Divisi Ekonomi & UMKM', 'nama' => 'Nafilah Pratiwi'],
                    ['posisi' => 'Divisi Media & Digital', 'nama' => 'Bos Andi (Kontributor Senior)'],
                    ['posisi' => 'Koordinator Ranting', 'nama' => 'Perwakilan 23 Desa'],
                ];
            @endphp
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($struktur as $item)
                    <div class="rounded-3xl border border-slate-100 bg-gradient-to-br from-white to-nu-50/40 p-6 shadow-sm">
                        <!-- Default Photo -->
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-nu-200 shadow-sm">
                                <img src="{{ \App\Models\OrganizationSetting::getDefaultProfilePhoto() }}" 
                                     alt="{{ $item['nama'] }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold mb-2">{{ $item['posisi'] }}</p>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $item['nama'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="bg-nu-50 rounded-3xl p-8">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-600 font-semibold">Relawan &amp; Kontributor</p>
            <p class="text-slate-600 mt-3">Lebih dari 120 relawan aktif terdiri dari banser, fatayat, IPNU-IPPNU, komunitas pecinta alam, serta kontributor media warga yang tersebar di 23 ranting NU. Mereka menjadi tulang punggung program lapangan dan publikasi berita.</p>
        </div>
    </section>
@endsection

