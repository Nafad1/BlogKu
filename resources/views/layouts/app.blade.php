<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlogKu - Universitas Negeri Medan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .unimed-gradient { background: linear-gradient(135deg, #1a3d7c 0%, #2a5bb0 100%); }
        .gold-accent { color: #d4a017; }
        .bg-gold { background-color: #d4a017; }
        .border-gold { border-color: #d4a017; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800">

    <div class="unimed-gradient text-white text-xs sm:text-sm">
        <div class="max-w-6xl mx-auto px-4 py-2 flex justify-between items-center">
            <span class="font-medium tracking-wide">Fakultas Matematika dan Ilmu Pengetahuan Alam</span>
            <span class="hidden sm:block text-white/80">Universitas Negeri Medan</span>
        </div>
    </div>

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full unimed-gradient flex items-center justify-center text-white font-bold text-lg shadow-md">
                        B
                    </div>
                    <div class="leading-tight">
                        <div class="font-bold text-slate-800 text-lg">BlogKu</div>
                        <div class="text-xs text-slate-500 tracking-wide">UNIMED Academic Blog</div>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1a3d7c] hover:bg-slate-100 rounded-lg transition">Beranda</a>

                    @auth
                        <a href="{{ route('bookmarks.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1a3d7c] hover:bg-slate-100 rounded-lg transition">Bookmark</a>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1a3d7c] hover:bg-slate-100 rounded-lg transition">Dashboard</a>
                        <a href="{{ route('posts.create') }}" class="ml-2 inline-flex items-center gap-2 bg-[#1a3d7c] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#2a5bb0] transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tulis
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="ml-1">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-[#1a3d7c] hover:bg-slate-100 rounded-lg transition">Masuk</a>
                        <a href="{{ route('register') }}" class="ml-2 bg-[#1a3d7c] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#2a5bb0] transition shadow-sm">Daftar</a>
                    @endauth
                </div>

                <button id="mobileMenuBtn" class="md:hidden p-2 text-slate-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-slate-100 mt-2">
                <div class="pt-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">Beranda</a>
                    @auth
                        <a href="{{ route('bookmarks.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">Bookmark</a>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">Dashboard</a>
                        <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-sm font-semibold text-[#1a3d7c] hover:bg-slate-100 rounded-lg">+ Tulis Artikel</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-[#1a3d7c] font-semibold hover:bg-slate-100 rounded-lg">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-6xl mx-auto w-full px-4 py-8">
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-[#1a3d7c] text-white mt-16">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-white text-[#1a3d7c] flex items-center justify-center font-bold">B</div>
                        <span class="font-bold text-lg">BlogKu</span>
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed">Platform blog akademik untuk berbagi gagasan, riset, dan pengetahuan di lingkungan Universitas Negeri Medan.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-white">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="{{ route('home') }}" class="hover:text-[#d4a017] transition">Beranda</a></li>
                        @auth
                            <li><a href="{{ route('posts.create') }}" class="hover:text-[#d4a017] transition">Tulis Artikel</a></li>
                            <li><a href="{{ route('bookmarks.index') }}" class="hover:text-[#d4a017] transition">Bookmark</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-6 text-center text-sm text-white/60">
                &copy; {{ date('Y') }} BlogKu &middot; Universitas Negeri Medan. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>