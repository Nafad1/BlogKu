@extends('layouts.app')
@section('title', $post->title)

@section('content')
<article class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
    @if ($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-64 object-cover rounded mb-6">
    @endif

    <span class="text-sm font-semibold text-blue-600 uppercase">{{ $post->category->name }}</span>
    <h1 class="text-4xl font-bold text-gray-800 mt-2 mb-4">{{ $post->title }}</h1>

    @php
        $wordCount = str_word_count(strip_tags($post->body));
        $readingTime = max(1, ceil($wordCount / 200));
    @endphp

    <div class="text-sm text-gray-500 mb-6 flex flex-wrap items-center gap-3">
        <span>Oleh <a href="{{ route('authors.show', $post->user) }}" class="text-blue-600 hover:underline font-semibold">{{ $post->user->name }}</a></span>
        <span>·</span>
        <span>{{ $post->created_at->format('d M Y') }}</span>
        <span>·</span>
        <span>⏱️ {{ $readingTime }} menit baca</span>
    </div>

    <div class="flex flex-wrap items-center gap-3 mb-6 py-4 border-t border-b">
        <button id="likeBtn" 
                data-url="{{ route('posts.like', $post) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ auth()->check() && $post->isLikedBy(auth()->id()) ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            <span>❤️</span>
            <span id="likeCount">{{ $post->likes()->count() }}</span>
            <span>Suka</span>
        </button>

        <button id="bookmarkBtn"
                data-url="{{ route('posts.bookmark', $post) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg transition {{ auth()->check() && $post->isBookmarkedBy(auth()->id()) ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            <span>🔖</span>
            <span id="bookmarkCount">{{ $post->bookmarks()->count() }}</span>
            <span>Simpan</span>
        </button>

        <span class="text-gray-500 ml-auto">👁️ {{ $post->views }} views</span>
    </div>

    <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
        {!! $post->body !!}
    </div>

    <div class="flex flex-wrap gap-2 mb-6 py-4 border-t border-b">
        <span class="text-sm font-semibold text-gray-600 self-center">Bagikan:</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white text-sm px-4 py-1 rounded hover:bg-blue-700">Facebook</a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-sky-500 text-white text-sm px-4 py-1 rounded hover:bg-sky-600">Twitter</a>
        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="bg-green-500 text-white text-sm px-4 py-1 rounded hover:bg-green-600">WhatsApp</a>
        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-blue-400 text-white text-sm px-4 py-1 rounded hover:bg-blue-500">Telegram</a>
    </div>

    @auth
        @can('update', $post)
            <div class="flex gap-2 pt-4 border-t">
                <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Hapus</button>
                </form>
            </div>
        @endcan
    @endauth

    <div class="mt-8 pt-4 border-t">
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Kembali ke Beranda</a>
    </div>
</article>

@if ($relatedPosts->count() > 0)
<section class="max-w-3xl mx-auto mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Artikel Terkait</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($relatedPosts as $related)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                @if ($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-32 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-2xl">📄</div>
                @endif
                <div class="p-3">
                    <h3 class="font-bold text-gray-800 text-sm mb-1">
                        <a href="{{ route('posts.show', $related->slug) }}" class="hover:text-blue-600">{{ $related->title }}</a>
                    </h3>
                    <p class="text-xs text-gray-400">👁️ {{ $related->views }} views</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

<section class="max-w-3xl mx-auto mt-8 bg-white rounded-lg shadow-md p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        💬 Komentar ({{ $post->comments->count() }})
    </h2>

    @auth
        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
            @csrf
            <textarea name="body" rows="3" 
                      class="w-full border-2 border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:outline-none @error('body') border-red-500 @enderror"
                      placeholder="Tulis komentar..."></textarea>
            @error('body')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            <button type="submit" class="mt-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Kirim Komentar
            </button>
        </form>
    @else
        <p class="text-gray-500 mb-6">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> untuk berkomentar.
        </p>
    @endauth

    <div class="space-y-4">
        @forelse ($post->comments as $comment)
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                    <div>
                        <strong class="text-gray-800">{{ $comment->user->name }}</strong>
                        <span class="text-xs text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    @auth
                        @if (auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:underline">Hapus</button>
                            </form>
                        @endif
                    @endauth
                </div>
                <p class="text-gray-700 mt-1">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.getElementById('likeBtn');
    const bookmarkBtn = document.getElementById('bookmarkBtn');

    async function toggle(url) {
        const token = '{{ csrf_token() }}';
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
        });
        return await response.json();
    }

    if (likeBtn) {
        likeBtn.addEventListener('click', async function() {
            @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            const data = await toggle(this.dataset.url);
            document.getElementById('likeCount').textContent = data.count;

            if (data.liked) {
                likeBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                likeBtn.classList.add('bg-red-500', 'text-white');
            } else {
                likeBtn.classList.remove('bg-red-500', 'text-white');
                likeBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            }
        });
    }

    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', async function() {
            @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            const data = await toggle(this.dataset.url);
            document.getElementById('bookmarkCount').textContent = data.count;

            if (data.bookmarked) {
                bookmarkBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                bookmarkBtn.classList.add('bg-yellow-500', 'text-white');
            } else {
                bookmarkBtn.classList.remove('bg-yellow-500', 'text-white');
                bookmarkBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            }
        });
    }
});
</script>
@endpush
@endsection