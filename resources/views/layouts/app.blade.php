<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lazisnu MWC NU Balongbendo')</title>
    
    @if(\App\Models\SiteSetting::get('site_favicon'))
        <link rel="icon" type="image/png" href="{{ \App\Models\SiteSetting::get('site_favicon') }}">
        <link rel="shortcut icon" type="image/png" href="{{ \App\Models\SiteSetting::get('site_favicon') }}">
    @endif
    
    @if(\App\Models\SiteSetting::get('adsense_enabled') && \App\Models\SiteSetting::get('adsense_client_id'))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ \App\Models\SiteSetting::get('adsense_client_id') }}" crossorigin="anonymous"></script>
    @endif
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Portal berita dan informasi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Lazisnu, NU, Balongbendo, zakat, infak, sedekah, program sosial, berita')">
    <meta name="author" content="@yield('meta_author', 'Lazisnu MWC NU Balongbendo')">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Lazisnu MWC NU Balongbendo')">
    <meta property="og:description" content="@yield('og_description', 'Portal berita dan informasi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')">
    <meta property="og:image" content="@yield('og_image', asset('images/lazisnu-og-default.svg'))">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Lazisnu MWC NU Balongbendo">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Lazisnu MWC NU Balongbendo')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Portal berita dan informasi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/lazisnu-og-default.svg'))">
    <meta name="twitter:site" content="@lazisnu_balongbendo">
    <meta name="twitter:creator" content="@lazisnu_balongbendo">
    
    <!-- WhatsApp Meta Tags -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'Lazisnu MWC NU Balongbendo')">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Lazisnu MWC NU Balongbendo",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/lazisnu-og-default.svg') }}",
        "description": "Lembaga Amil Zakat MWC NU Balongbendo - Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. KH. Hasyim Asy'ari No. 12",
            "addressLocality": "Balongbendo",
            "addressRegion": "Sidoarjo",
            "addressCountry": "ID"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-813-1234-5678",
            "contactType": "Customer Service",
            "email": "media@lazisnubalongbendo.or.id"
        },
        "sameAs": [
            "https://instagram.com/lazisnu.balongbendo",
            "https://facebook.com/Lazisnu-Balongbendo"
        ]
    }
    </script>
    
    @stack('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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
                        nuPrimary: '#0B8A3A',
                        nuDark: '#06381a',
                    },
                    fontFamily: {
                        display: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.87);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white/95 border-b border-slate-200 sticky top-0 z-20 backdrop-blur">
            <div class="max-w-6xl mx-auto px-6 py-4">
                <!-- Desktop Header -->
                <div class="hidden md:flex md:items-center md:justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        @if(\App\Models\SiteSetting::get('site_logo'))
                            <img src="{{ \App\Models\SiteSetting::get('site_logo') }}" alt="Logo" class="h-12 object-contain">
                        @else
                            <span class="h-12 w-12 rounded-2xl bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-semibold shadow-lg">NU</span>
                        @endif
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-nu-600 font-semibold">{{ \App\Models\SiteSetting::get('site_subtitle', 'Lazisnu MWC NU') }}</p>
                            <p class="text-xl font-bold text-nu-900">{{ \App\Models\SiteSetting::get('site_title', 'Balongbendo Newsroom') }}</p>
                        </div>
                    </a>
                    <nav class="flex items-center gap-4 text-sm font-medium text-slate-600">
                        <!-- Dropdown Profil di posisi pertama -->
                        <div class="relative group">
                            <button class="flex items-center gap-1 {{ request()->routeIs(['sambutan', 'struktur', 'visi-misi']) ? 'text-nu-600 font-semibold' : 'hover:text-nu-500' }}">
                                Profil
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('visi-misi') }}" class="block px-4 py-3 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-t-lg">Visi Misi</a>
                                <a href="{{ route('sambutan') }}" class="block px-4 py-3 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600">Sambutan</a>
                                <a href="{{ route('struktur') }}" class="block px-4 py-3 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-b-lg">Struktur</a>
                            </div>
                        </div>
                        
                        <!-- Dropdown Berita dengan Kategori -->
                        <div class="relative group">
                            <button class="flex items-center gap-1 {{ request()->routeIs(['news', 'articles.show']) ? 'text-nu-600 font-semibold' : 'hover:text-nu-500' }}">
                                Berita
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('news') }}" class="block px-4 py-3 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-t-lg font-medium">Semua Berita</a>
                                <div class="border-t border-slate-100"></div>
                                @php
                                    $categories = \App\Models\Category::orderBy('name')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="block px-4 py-3 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 {{ $loop->last ? 'rounded-b-lg' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <a href="{{ route('programs') }}" class="{{ request()->routeIs('programs') ? 'text-nu-600 font-semibold' : 'hover:text-nu-500' }}">Program</a>
                        <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'text-nu-600 font-semibold' : 'hover:text-nu-500' }}">Galeri</a>
                        
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-nu-600 font-semibold' : 'hover:text-nu-500' }}">Kontak</a>

                        @guest
                            <a href="{{ route('admin.login') }}" class="hover:text-nu-500">Masuk</a>
                        @endguest
                    </nav>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden">
                    <div class="flex items-center justify-between mb-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                            @if(\App\Models\SiteSetting::get('site_logo'))
                                <img src="{{ \App\Models\SiteSetting::get('site_logo') }}" alt="Logo" class="h-10 object-contain">
                            @else
                                <span class="h-10 w-10 rounded-xl bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-semibold text-sm shadow-lg">NU</span>
                            @endif
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-nu-600 font-semibold">{{ \App\Models\SiteSetting::get('site_subtitle', 'Lazisnu MWC NU') }}</p>
                                <p class="text-lg font-bold text-nu-900">{{ \App\Models\SiteSetting::get('site_title', 'Balongbendo Newsroom') }}</p>
                            </div>
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="text-nu-600 text-sm font-medium">Masuk</a>
                        @endguest
                    </div>
                    
                    <!-- Mobile Navigation - Scrollable -->
                    <div class="overflow-x-auto">
                        <nav class="flex gap-4 text-sm font-medium text-slate-600 pb-2" style="min-width: max-content;">
                            <a href="{{ route('home') }}" class="whitespace-nowrap {{ request()->routeIs('home') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Beranda</a>
                            <a href="{{ route('visi-misi') }}" class="whitespace-nowrap {{ request()->routeIs('visi-misi') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Visi Misi</a>
                            <a href="{{ route('news') }}" class="whitespace-nowrap {{ request()->routeIs(['news', 'articles.show']) ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Berita</a>
                            @php
                                $categories = \App\Models\Category::orderBy('name')->take(3)->get();
                            @endphp
                            @foreach($categories as $category)
                                <a href="{{ route('news', ['category' => $category->slug]) }}" class="whitespace-nowrap {{ request('category') === $category->slug ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">{{ $category->name }}</a>
                            @endforeach
                            <a href="{{ route('programs') }}" class="whitespace-nowrap {{ request()->routeIs('programs') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Program</a>
                            <a href="{{ route('gallery') }}" class="whitespace-nowrap {{ request()->routeIs('gallery') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Galeri</a>
                            <a href="{{ route('sambutan') }}" class="whitespace-nowrap {{ request()->routeIs('sambutan') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Sambutan</a>
                            <a href="{{ route('struktur') }}" class="whitespace-nowrap {{ request()->routeIs('struktur') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Struktur</a>
                            <a href="{{ route('contact') }}" class="whitespace-nowrap {{ request()->routeIs('contact') ? 'text-nu-600 font-semibold border-b-2 border-nu-600 pb-1' : 'hover:text-nu-500' }}">Kontak</a>
                        </nav>
                    </div>
                </div>
            </div>
            @if (session('status'))
                <div class="bg-nu-600 text-white text-center py-2 text-sm">
                    {{ session('status') }}
                </div>
            @endif
        </header>

        @if(\App\Models\SiteSetting::get('adsense_enabled') && \App\Models\SiteSetting::get('adsense_header_ad'))
            <div class="bg-gray-50 py-4">
                <div class="max-w-6xl mx-auto px-6 text-center">
                    {!! \App\Models\SiteSetting::get('adsense_header_ad') !!}
                </div>
            </div>
        @endif

        <main class="flex-1">
            @yield('content')
        </main>

        @php
            $footerContact = \App\Models\ContactSetting::firstOrCreate([]);
        @endphp
        <footer id="kontak" class="bg-nuDark text-white mt-16">
            <div class="max-w-6xl mx-auto px-6 py-12 grid gap-10 md:grid-cols-3">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-nu-200 font-semibold">Lazisnu MWC NU</p>
                    <p class="text-2xl font-bold mt-1">Balongbendo</p>
                    <p class="text-sm text-nu-100 mt-4 leading-relaxed">{{ $footerContact->header_description }}</p>
                </div>
                <div>
                    <p class="font-semibold text-lg">{{ $footerContact->office_title }}</p>
                    <p class="text-sm text-nu-100 mt-2 leading-relaxed">
                        {!! nl2br(e($footerContact->office_address)) !!}<br>
                        <span class="text-nu-200">{{ $footerContact->office_hours }}</span>
                    </p>
                </div>
                <div>
                    <p class="font-semibold text-lg">Kontak</p>
                    <ul class="mt-2 text-sm text-nu-100 space-y-2">
                        <li>📞 {{ $footerContact->phone }} (Call Center)</li>
                        <li>✉️ {{ $footerContact->email }}</li>
                        @if($footerContact->instagram)
                            <li>IG: {{ $footerContact->instagram }}</li>
                        @endif
                        @if($footerContact->facebook)
                            <li>FB: {{ $footerContact->facebook }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 text-center text-xs text-nu-200 py-4">
                <p>© {{ date('Y') }} Lazisnu MWC NU Balongbendo. All rights reserved.</p>
                <p class="mt-1">Dev by <a href="https://andidev.id" target="_blank" class="text-nu-400 hover:text-nu-300 font-medium">Bos Andi</a></p>
            </div>
        </footer>
    </div>
</body>
</html>

