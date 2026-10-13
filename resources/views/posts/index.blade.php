@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Artikel Terbaru</h1>

    <form method="GET" action="{{ route('home') }}" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari artikel..." 
               class="border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none">
        
        <select name="category" class="border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Cari</button>
        
        @if (request()->filled('search') || request()->filled('category'))
            <a href="{{ route('home') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 text-center">Reset</a>
        @endif
    </form>
</div>

@if (request()->filled('search') || request()->filled('category'))
    <p class="text-gray-600 mb-4">
        Menampilkan {{ $posts->total() }} hasil
        @if (request('search')) untuk pencarian "<strong>{{ request('search') }}</strong>"@endif
        @if (request('category')) di kategori <strong>{{ $categories->find(request('category'))->name ?? '' }}</strong>@endif
    </p>
@endif

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl">📝</div>
                    @endif
                    <div class="p-5">
                        <span class="text-xs font-semibold text-blue-600 uppercase">{{ $post->category->name }}</span>
                        <h2 class="text-lg font-bold text-gray-800 mt-1 mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 mb-3">{{ Str::limit(strip_tags($post->body), 80) }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-400">
                            <span>Oleh {{ $post->user->name }}</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <p class="col-span-3 text-center py-12 text-gray-500">Belum ada artikel.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $posts->links() }}</div>
    </div>

    <aside class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-5 sticky top-24">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">🔥 Trending</h3>
            <div class="space-y-3">
                @php
                    $trending = \App\Models\Post::where('status', 'published')->orderBy('views', 'desc')->take(5)->get();
                @endphp
                @foreach ($trending as $i => $tp)
                    <a href="{{ route('posts.show', $tp->slug) }}" class="flex gap-3 hover:bg-gray-50 p-2 rounded transition">
                        <span class="text-2xl font-bold text-gray-300">{{ $i + 1 }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Str::limit($tp->title, 50) }}</p>
                            <p class="text-xs text-gray-400 mt-1">👁️ {{ $tp->views }} views</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>
@endsection