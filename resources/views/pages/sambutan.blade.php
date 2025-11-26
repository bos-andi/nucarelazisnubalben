@extends('layouts.app')

@section('title', $welcomeMessage->title ?? 'Sambutan Ketua Lazisnu Balongbendo')

@section('content')
    <section class="bg-gradient-to-br from-nu-900 via-nu-700 to-nu-500 text-white relative overflow-hidden">
        @if($welcomeMessage && $welcomeMessage->image)
            <div class="absolute inset-0 bg-black/40"></div>
            <img src="{{ $welcomeMessage->image }}" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        @endif
        
        <div class="max-w-4xl mx-auto px-6 py-12 text-center relative z-10">
            <p class="text-xs uppercase tracking-[0.4em] text-nu-100 font-semibold">Sambutan Ketua</p>
            <h1 class="text-4xl md:text-5xl font-bold mt-4">
                {{ $welcomeMessage->title ?? 'Menebar Manfaat, Merawat Peradaban Hijau' }}
            </h1>
            <p class="text-nu-100 mt-4">Pesan hangat dari Ketua Lazisnu MWC NU Balongbendo untuk jamaah Nahdliyin, donatur, dan mitra kebaikan.</p>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 md:px-6 mt-8 md:mt-4 lg:-mt-4 relative">
        <div class="rounded-[24px] md:rounded-[32px] bg-white shadow-2xl border border-slate-100 overflow-hidden">
            @if($welcomeMessage)
                <!-- Chairman Photo Section -->
                @php
                    $chairmanPhoto = $welcomeMessage->getChairmanPhoto();
                @endphp
                
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 p-6 md:p-8 bg-gradient-to-br from-nu-50 to-nu-100 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                            <img src="{{ $chairmanPhoto }}" alt="Foto Ketua" class="w-full h-full object-cover">
                        </div>
                        @php
                            $chairmanName = 'H. Ahmad Syamsudin'; // Default name
                            $chairmanTitle = 'Ketua Lazisnu MWC NU Balongbendo'; // Default title
                            
                            // Try to get chairman info from organization structure
                            $orgStructure = \App\Models\OrganizationSetting::getByKey('organization_structure');
                            if ($orgStructure && $orgStructure->data && isset($orgStructure->data['positions'])) {
                                foreach ($orgStructure->data['positions'] as $position) {
                                    if (isset($position['is_chairman']) && $position['is_chairman']) {
                                        $chairmanName = $position['name'];
                                        $chairmanTitle = $position['title'];
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <h3 class="text-base md:text-lg font-bold text-nu-800">{{ $chairmanName }}</h3>
                        <p class="text-xs md:text-sm text-nu-600 font-semibold">{{ $chairmanTitle }}</p>
                    </div>
                    
                    <div class="md:w-2/3 p-6 md:p-8 lg:p-10 space-y-4 md:space-y-6">
                        <div class="prose prose-slate max-w-none text-sm md:text-base leading-relaxed">
                            {!! nl2br(e($welcomeMessage->content)) !!}
                        </div>
                    </div>
                </div>
            @else
                <!-- Fallback content when no welcome message is set -->
                <div class="p-6 md:p-8 lg:p-10 space-y-4 md:space-y-6">
                    <p class="text-xs md:text-sm uppercase tracking-[0.4em] text-nu-600 font-semibold">H. Ahmad Syamsudin</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Ketua Lazisnu MWC NU Balongbendo</h2>
                    <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                        Assalamualaikum warahmatullahi wabarakatuh.<br><br>
                        Alhamdulillah, atas ridha Allah SWT dan dukungan keluarga besar Nahdliyin, Lazisnu Balongbendo terus meluaskan jangkauan program: dari sedekah pagi, respon kebencanaan, hingga beasiswa santri produktif. Semua bergerak karena jejaring ranting, banom, dan para dermawan yang istiqamah menebar manfaat.
                    </p>
                    <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                        Di tengah tantangan iklim dan ekonomi, kami percaya gerakan hijau ala NU — menanam pohon, mengawal UMKM ramah lingkungan, dan digitalisasi donasi — adalah ikhtiar menjaga bumi sekaligus memuliakan manusia. Mari kuatkan kolaborasi, pastikan setiap rupiah zakat/infak sampai ke mustahik yang tepat, transparan, dan berdampak.
                    </p>
                    <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                        Terima kasih kepada seluruh relawan, dai, donatur, dan sahabat media yang setiap hari menyiarkan kabar kebaikan Balongbendo. Semoga Allah melapangkan rezeki dan meneguhkan langkah panjenengan semua.
                    </p>
                    <p class="text-sm md:text-base font-semibold text-nu-700">Wassalamualaikum warahmatullahi wabarakatuh.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

