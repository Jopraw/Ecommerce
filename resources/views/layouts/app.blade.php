<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AstroStep - Melangkah Pasti, Aman Bertransaksi' }}</title>
    <meta name="description" content="AstroStep - Platform E-Commerce Alas Kaki Terpercaya">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-bg-primary/95 backdrop-blur-md border-b border-border-dark" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-accent-orange" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 22h20L12 2zm0 4l7 14H5l7-14z"/>
                    </svg>
                    <span class="text-xl font-bold tracking-tight">ASTRO<span class="text-accent-orange">STEP</span></span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-accent-orange' : 'text-text-secondary hover:text-white' }} transition-colors">Home</a>
                    <a href="{{ route('shop.index') }}" class="text-sm font-medium {{ request()->routeIs('shop.*') ? 'text-accent-orange' : 'text-text-secondary hover:text-white' }} transition-colors">Shop</a>
                    <a href="{{ route('collections') }}" class="text-sm font-medium {{ request()->routeIs('collections') ? 'text-accent-orange' : 'text-text-secondary hover:text-white' }} transition-colors">Collections</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium {{ request()->routeIs('about') ? 'text-accent-orange' : 'text-text-secondary hover:text-white' }} transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium {{ request()->routeIs('contact') ? 'text-accent-orange' : 'text-text-secondary hover:text-white' }} transition-colors">Contact</a>
                </div>

                {{-- Right Icons --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('shop.index') }}" class="text-text-secondary hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </a>

                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-text-secondary hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-bg-card border border-border-dark rounded-lg shadow-xl py-1 z-50">
                                <div class="px-4 py-2 border-b border-border-dark">
                                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-text-muted truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-text-secondary hover:bg-bg-secondary hover:text-white">Pesanan Saya</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-accent-orange hover:bg-bg-secondary">Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-text-secondary hover:bg-bg-secondary hover:text-white">Keluar</button>
                                </form>
                            </div>
                        </div>

                        <a href="{{ route('cart.index') }}" class="relative text-text-secondary hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            @php $cartCount = auth()->user()->carts()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-accent-orange text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-text-secondary hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm bg-accent-orange hover:bg-accent-orange-dark text-white px-4 py-2 rounded-lg transition-colors font-medium">Daftar</a>
                    @endauth

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden text-text-secondary hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-transition class="md:hidden bg-bg-secondary border-t border-border-dark">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-text-secondary hover:text-accent-orange">Home</a>
                <a href="{{ route('shop.index') }}" class="block py-2 text-text-secondary hover:text-accent-orange">Shop</a>
                <a href="{{ route('collections') }}" class="block py-2 text-text-secondary hover:text-accent-orange">Collections</a>
                <a href="{{ route('about') }}" class="block py-2 text-text-secondary hover:text-accent-orange">About</a>
                <a href="{{ route('contact') }}" class="block py-2 text-text-secondary hover:text-accent-orange">Contact</a>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
             class="fixed top-20 right-4 z-50 bg-green-500/20 border border-green-500/50 text-green-400 px-6 py-3 rounded-lg shadow-xl backdrop-blur-md">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
             class="fixed top-20 right-4 z-50 bg-red-500/20 border border-red-500/50 text-red-400 px-6 py-3 rounded-lg shadow-xl backdrop-blur-md">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-bg-secondary border-t border-border-dark mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 text-accent-orange" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2zm0 4l7 14H5l7-14z"/></svg>
                        <span class="text-lg font-bold">ASTRO<span class="text-accent-orange">STEP</span></span>
                    </a>
                    <p class="text-text-muted text-sm">Melangkah Pasti, Aman Bertransaksi. Platform E-Commerce Alas Kaki Terpercaya.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-accent-orange mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white transition-colors">Shop</a></li>
                        <li><a href="{{ route('collections') }}" class="hover:text-white transition-colors">Collections</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-accent-orange mb-4">Kategori</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('shop.index', ['category' => 'sneakers']) }}" class="hover:text-white transition-colors">Sneakers</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'formal']) }}" class="hover:text-white transition-colors">Sepatu Formal</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'sandal']) }}" class="hover:text-white transition-colors">Sandal</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'perawatan']) }}" class="hover:text-white transition-colors">Perawatan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-accent-orange mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li>📧 tim@astrostep.com</li>
                        <li>📱 +62 812-3456-7890</li>
                        <li>🌐 www.astrostep.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-border-dark mt-8 pt-8 text-center text-text-muted text-sm">
                &copy; {{ date('Y') }} AstroStep. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
