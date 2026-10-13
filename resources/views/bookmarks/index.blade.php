@extends('layouts.app')
@section('title', 'Bookmark Saya')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">🔖 Artikel yang Disimpan</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($bookmarks as $bookmark)
        @php $post = $bookmark->post; @endphp
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white text-4xl">🔖</div>
            @endif
            <div class="p-5">
                <span class="text-xs font-semibold text-blue-600 uppercase">{{ $post->category->name }}</span>
                <h2 class="text-lg font-bold text-gray-800 mt-1 mb-2">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                </h2>
                <p class="text-sm text-gray-500 mb-3">{{ Str::limit(strip_tags($post->body), 80) }}</p>
                <div class="flex justify-between items-center text-xs text-gray-400">
                    <span>Oleh {{ $post->user->name }}</span>
                    <span>{{ $bookmark->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </article>
    @empty
        <p class="col-span-3 text-center py-12 text-gray-500">Belum ada artikel yang disimpan.</p>
    @endforelse
</div>

<div class="mt-8">{{ $bookmarks->links() }}</div>
@endsection