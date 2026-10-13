@extends('layouts.app')
@section('title', 'Bookmark Saya')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Artikel yang Disimpan</h1>
    <p class="text-sm text-slate-500 mt-1">{{ $bookmarks->total() }} artikel tersimpan</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($bookmarks as $bookmark)
        @php $post = $bookmark->post; @endphp
        <article class="bg-white rounded-xl shadow-sm hover:shadow-lg border border-slate-100 overflow-hidden transition group">
            <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-48 unimed-gradient flex items-center justify-center text-white">
                        <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </div>
                @endif
            </a>
            <div class="p-5">
                <span class="inline-block text-xs font-semibold text-[#d4a017] uppercase tracking-wider mb-2">{{ $post->category->name }}</span>
                <h3 class="text-base font-bold text-slate-800 mb-2 leading-snug group-hover:text-[#1a3d7c] transition">
                    <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->title, 60) }}</a>
                </h3>
                <p class="text-sm text-slate-500 mb-4">{{ Str::limit(strip_tags($post->body), 80) }}</p>
                <div class="flex justify-between items-center text-xs text-slate-400 pt-3 border-t border-slate-100">
                    <span class="font-medium text-slate-600">{{ $post->user->name }}</span>
                    <span>{{ $bookmark->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </article>
    @empty
        <div class="col-span-3 text-center py-16 bg-white rounded-xl border border-dashed border-slate-300">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            <p class="text-slate-500 font-medium">Belum ada artikel yang disimpan</p>
            <a href="{{ route('home') }}" class="inline-block mt-3 text-sm text-[#1a3d7c] font-semibold hover:underline">Jelajahi Artikel</a>
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $bookmarks->links() }}</div>
@endsection