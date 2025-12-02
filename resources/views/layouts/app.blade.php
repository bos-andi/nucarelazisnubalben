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
    @if(View::hasSection('og_image'))
        <meta property="og:image" content="@yield('og_image')">
    @else
        <meta property="og:image" content="{{ asset('images/lazisnu-og-default.svg') }}">
    @endif
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Lazisnu MWC NU Balongbendo">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Lazisnu MWC NU Balongbendo')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Portal berita dan informasi Lazisnu MWC NU Balongbendo. Menebar manfaat melalui zakat, infak, sedekah, dan program kemandirian untuk warga Balongbendo dan sekitarnya.')">
    @if(View::hasSection('twitter_image'))
        <meta name="twitter:image" content="@yield('twitter_image')">
    @elseif(View::hasSection('og_image'))
        <meta name="twitter:image" content="@yield('og_image')">
    @else
        <meta name="twitter:image" content="{{ asset('images/lazisnu-og-default.svg') }}">
    @endif
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
        <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Desktop Header -->
                <div class="hidden md:flex md:items-center md:justify-between md:py-4">
                    <!-- Logo Section -->
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            @if(\App\Models\SiteSetting::get('site_logo'))
                                <img src="{{ \App\Models\SiteSetting::get('site_logo') }}" alt="Logo" class="h-10 object-contain">
                            @else
                                <span class="h-10 w-10 rounded-lg bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-bold shadow">NU</span>
                            @endif
                            <div>
                                <p class="text-xs font-semibold text-nu-600 leading-tight">{{ \App\Models\SiteSetting::get('site_subtitle', 'LAZISNU MWC NU') }}</p>
                                <p class="text-sm font-bold text-nu-900 leading-tight">{{ \App\Models\SiteSetting::get('site_title', 'NU Care Lazisnu Balongbendo') }}</p>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <nav class="flex items-center gap-6 text-sm font-medium text-slate-700">
                        <a href="{{ route('home') }}" class="hover:text-nu-600 transition-colors {{ request()->routeIs('home') ? 'text-nu-600 font-semibold' : '' }}">
                            Beranda
                        </a>
                        
                        <!-- Profil Dropdown -->
                        <div class="relative group">
                            <a href="#" class="flex items-center gap-1 hover:text-nu-600 transition-colors {{ request()->routeIs(['sambutan', 'struktur', 'visi-misi']) ? 'text-nu-600 font-semibold' : '' }}">
                                Profil
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('visi-misi') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-t-lg">Visi Misi</a>
                                <a href="{{ route('sambutan') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600">Sambutan</a>
                                <a href="{{ route('struktur') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-b-lg">Struktur</a>
                            </div>
                        </div>
                        
                        <!-- Berita Dropdown -->
                        <div class="relative group">
                            <a href="#" class="flex items-center gap-1 hover:text-nu-600 transition-colors {{ request()->routeIs(['news', 'articles.show']) ? 'text-nu-600 font-semibold' : '' }}">
                                Berita
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <div class="absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('news') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 rounded-t-lg font-medium">Semua Berita</a>
                                <div class="border-t border-slate-100"></div>
                                @php
                                    $categories = \App\Models\Category::orderBy('name')->get();
                                @endphp
                                @foreach($categories as $category)
                                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-nu-50 hover:text-nu-600 {{ $loop->last ? 'rounded-b-lg' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <a href="{{ route('programs') }}" class="hover:text-nu-600 transition-colors {{ request()->routeIs('programs') ? 'text-nu-600 font-semibold' : '' }}">
                            Program
                        </a>
                        <a href="{{ route('gallery') }}" class="hover:text-nu-600 transition-colors {{ request()->routeIs('gallery') ? 'text-nu-600 font-semibold' : '' }}">
                            Galeri
                        </a>
                        <a href="{{ route('khutbah') }}" class="hover:text-nu-600 transition-colors {{ request()->routeIs(['khutbah', 'khutbah.show']) ? 'text-nu-600 font-semibold' : '' }}">
                            Khutbah
                        </a>
                        <a href="{{ route('contact') }}" class="hover:text-nu-600 transition-colors {{ request()->routeIs('contact') ? 'text-nu-600 font-semibold' : '' }}">
                            Kontak
                        </a>
                    </nav>
                </div>

                <!-- Mobile Header -->
                <div class="md:hidden">
                    <div class="flex items-center justify-between py-3">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            @if(\App\Models\SiteSetting::get('site_logo'))
                                <img src="{{ \App\Models\SiteSetting::get('site_logo') }}" alt="Logo" class="h-8 object-contain">
                            @else
                                <span class="h-8 w-8 rounded-lg bg-gradient-to-br from-nu-500 to-nu-700 flex items-center justify-center text-white font-bold text-sm shadow">NU</span>
                            @endif
                            <div>
                                <p class="text-xs font-semibold text-nu-600 leading-tight">{{ \App\Models\SiteSetting::get('site_subtitle', 'LAZISNU MWC NU') }}</p>
                                <p class="text-sm font-bold text-nu-900 leading-tight">{{ \App\Models\SiteSetting::get('site_title', 'NU Care Lazisnu Balongbendo') }}</p>
                            </div>
                        </a>
                        
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn" class="p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Toggle menu">
                            <svg id="menu-icon" class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="close-icon" class="w-6 h-6 text-slate-700 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Mobile Navigation Menu -->
                    <div id="mobile-menu" class="hidden border-t border-slate-200">
                        <nav class="py-2 space-y-1">
                            <a href="{{ route('home') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-nu-600 bg-nu-50 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-nu-600' }} rounded-lg">
                                Beranda
                            </a>
                            
                            <!-- Profil Dropdown -->
                            <div class="mobile-dropdown">
                                <button class="mobile-dropdown-btn w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-nu-600 rounded-lg {{ request()->routeIs(['sambutan', 'struktur', 'visi-misi']) ? 'text-nu-600 bg-nu-50 font-semibold' : '' }}">
                                    <span>Profil</span>
                                    <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="mobile-dropdown-content hidden pl-4 space-y-1">
                                    <a href="{{ route('visi-misi') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('visi-misi') ? 'text-nu-600 font-semibold' : 'text-slate-600 hover:text-nu-600' }} rounded-lg">Visi Misi</a>
                                    <a href="{{ route('sambutan') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('sambutan') ? 'text-nu-600 font-semibold' : 'text-slate-600 hover:text-nu-600' }} rounded-lg">Sambutan</a>
                                    <a href="{{ route('struktur') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('struktur') ? 'text-nu-600 font-semibold' : 'text-slate-600 hover:text-nu-600' }} rounded-lg">Struktur</a>
                                </div>
                            </div>
                            
                            <!-- Berita Dropdown -->
                            <div class="mobile-dropdown">
                                <button class="mobile-dropdown-btn w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-nu-600 rounded-lg {{ request()->routeIs(['news', 'articles.show']) ? 'text-nu-600 bg-nu-50 font-semibold' : '' }}">
                                    <span>Berita</span>
                                    <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="mobile-dropdown-content hidden pl-4 space-y-1">
                                    <a href="{{ route('news') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('news') && !request('category') ? 'text-nu-600 font-semibold' : 'text-slate-600 hover:text-nu-600' }} rounded-lg">Semua Berita</a>
                                    @php
                                        $mobileCategories = \App\Models\Category::orderBy('name')->get();
                                    @endphp
                                    @foreach($mobileCategories as $category)
                                        <a href="{{ route('news', ['category' => $category->slug]) }}" class="block px-3 py-2 text-sm {{ request('category') === $category->slug ? 'text-nu-600 font-semibold' : 'text-slate-600 hover:text-nu-600' }} rounded-lg">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <a href="{{ route('programs') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('programs') ? 'text-nu-600 bg-nu-50 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-nu-600' }} rounded-lg">
                                Program
                            </a>
                            <a href="{{ route('gallery') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('gallery') ? 'text-nu-600 bg-nu-50 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-nu-600' }} rounded-lg">
                                Galeri
                            </a>
                            <a href="{{ route('khutbah') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs(['khutbah', 'khutbah.show']) ? 'text-nu-600 bg-nu-50 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-nu-600' }} rounded-lg">
                                Khutbah
                            </a>
                            <a href="{{ route('contact') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('contact') ? 'text-nu-600 bg-nu-50 font-semibold' : 'text-slate-700 hover:bg-slate-50 hover:text-nu-600' }} rounded-lg">
                                Kontak
                            </a>
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
    
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        }
        
        // Mobile Dropdown Toggle
        document.querySelectorAll('.mobile-dropdown-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const dropdown = btn.nextElementSibling;
                const icon = btn.querySelector('svg');
                
                dropdown.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
        
    </script>
</body>
</html>

