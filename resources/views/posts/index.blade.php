@extends('layouts.app')
@section('title', 'Beranda - BlogKu UNIMED')

@section('content')

<section class="unimed-gradient rounded-2xl p-8 md:p-12 mb-8 text-white shadow-lg relative overflow-hidden">
    <div class="relative z-10 max-w-3xl">
        <div class="inline-block bg-white/15 backdrop-blur border border-white/20 px-3 py-1 rounded-full text-xs font-medium mb-4 tracking-wide">
            PORTAL AKADEMIK UNIMED
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
            Berbagi Gagasan,<br>Membangun Pengetahuan
        </h1>
        <p class="text-white/80 text-base md:text-lg leading-relaxed mb-6 max-w-2xl">
            Kumpulan tulisan, riset, dan opini dari mahasiswa serta dosen Fakultas Matematika dan Ilmu Pengetahuan Alam.
        </p>
        @auth
            <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 bg-[#d4a017] text-[#1a3d7c] px-6 py-3 rounded-lg font-semibold hover:bg-[#e0b030] transition shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tulis Artikel Baru
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-[#d4a017] text-[#1a3d7c] px-6 py-3 rounded-lg font-semibold hover:bg-[#e0b030] transition shadow-md">
                Bergabung Sekarang
            </a>
        @endauth
    </div>
    <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-white/5"></div>
    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-[#d4a017]/10"></div>
</section>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Artikel Terbaru</h2>
        <p class="text-sm text-slate-500 mt-1">{{ $posts->total() }} artikel dipublikasikan</p>
    </div>

    <form method="GET" action="{{ route('home') }}" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
        <div class="relative">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                   class="w-full sm:w-64 pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:border-[#1a3d7c] focus:ring-1 focus:ring-[#1a3d7c] focus:outline-none bg-white">
        </div>

        <select name="category" class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:border-[#1a3d7c] focus:outline-none bg-white">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-[#1a3d7c] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#2a5bb0] transition">Cari</button>

        @if (request()->filled('search') || request()->filled('category'))
            <a href="{{ route('home') }}" class="bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-300 transition text-center">Reset</a>
        @endif
    </form>
</div>

@if (request()->filled('search') || request()->filled('category'))
    <div class="bg-[#1a3d7c]/5 border-l-4 border-[#1a3d7c] p-3 rounded-r-lg mb-6 text-sm text-slate-700">
        Menampilkan <strong>{{ $posts->total() }}</strong> hasil
        @if (request('search')) untuk pencarian "<strong>{{ request('search') }}</strong>"@endif
        @if (request('category')) di kategori <strong>{{ $categories->find(request('category'))->name ?? '' }}</strong>@endif
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-100 overflow-hidden transition group">
                    <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-48 unimed-gradient flex items-center justify-center text-white">
                                <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-5">
                        <span class="inline-block text-xs font-semibold text-[#d4a017] uppercase tracking-wider mb-2">{{ $post->category->name }}</span>
                        <h3 class="text-base font-bold text-slate-800 mb-2 leading-snug group-hover:text-[#1a3d7c] transition">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->title, 60) }}</a>
                        </h3>
                        <p class="text-sm text-slate-500 mb-4 leading-relaxed">{{ Str::limit(strip_tags($post->body), 80) }}</p>
                        <div class="flex justify-between items-center text-xs text-slate-400 pt-3 border-t border-slate-100">
                            <span class="font-medium text-slate-600">{{ $post->user->name }}</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-xl border border-dashed border-slate-300">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-slate-500 font-medium">Belum ada artikel yang ditemukan</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $posts->links() }}</div>
    </div>

    <aside class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sticky top-24">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                <span class="w-1.5 h-4 bg-[#d4a017] rounded"></span>
                Trending
            </h3>
            <div class="space-y-4">
                @php
                    $trending = \App\Models\Post::where('status', 'published')->orderBy('views', 'desc')->take(5)->get();
                @endphp
                @foreach ($trending as $i => $tp)
                    <a href="{{ route('posts.show', $tp->slug) }}" class="flex gap-3 group">
                        <span class="text-2xl font-extrabold text-slate-200 leading-none w-6">{{ $i + 1 }}</span>
                        <div class="flex-1 border-b border-slate-100 pb-3 last:border-0">
                            <p class="text-sm font-semibold text-slate-700 leading-snug group-hover:text-[#1a3d7c] transition">{{ Str::limit($tp->title, 60) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $tp->views }} views</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>
@endsection