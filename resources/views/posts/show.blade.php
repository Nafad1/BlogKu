@extends('layouts.app')
@section('title', $post->title)

@section('content')
<article class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    @if ($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-72 object-cover">
    @endif

    <div class="p-8 md:p-10">
        <span class="inline-block text-xs font-semibold text-[#d4a017] uppercase tracking-wider mb-3">{{ $post->category->name }}</span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 leading-tight mb-5">{{ $post->title }}</h1>

        @php
            $wordCount = str_word_count(strip_tags($post->body));
            $readingTime = max(1, ceil($wordCount / 200));
        @endphp

        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-slate-500 pb-5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-[#1a3d7c] text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <a href="{{ route('authors.show', $post->user) }}" class="font-semibold text-slate-700 hover:text-[#1a3d7c]">{{ $post->user->name }}</a>
            </div>
            <span class="text-slate-300">|</span>
            <span>{{ $post->created_at->format('d M Y') }}</span>
            <span class="text-slate-300">|</span>
            <span>{{ $readingTime }} menit baca</span>
            <span class="text-slate-300">|</span>
            <span>{{ $post->views }} views</span>
        </div>

        <div class="flex flex-wrap items-center gap-3 py-5 border-b border-slate-100">
            <button id="likeBtn" data-url="{{ route('posts.like', $post) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition border {{ auth()->check() && $post->isLikedBy(auth()->id()) ? 'bg-red-500 text-white border-red-500' : 'bg-white text-slate-700 border-slate-300 hover:border-red-400 hover:text-red-500' }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                <span id="likeCount">{{ $post->likes()->count() }}</span>
                <span>Suka</span>
            </button>

            <button id="bookmarkBtn" data-url="{{ route('posts.bookmark', $post) }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition border {{ auth()->check() && $post->isBookmarkedBy(auth()->id()) ? 'bg-[#d4a017] text-white border-[#d4a017]' : 'bg-white text-slate-700 border-slate-300 hover:border-[#d4a017] hover:text-[#d4a017]' }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-3-5 3V4z"/></svg>
                <span id="bookmarkCount">{{ $post->bookmarks()->count() }}</span>
                <span>Simpan</span>
            </button>
        </div>

        <div class="prose prose-slate max-w-none py-8 text-slate-700 leading-relaxed">
            {!! $post->body !!}
        </div>

        <div class="flex flex-wrap gap-2 py-5 border-t border-slate-100">
            <span class="text-sm font-semibold text-slate-600 self-center mr-2">Bagikan:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-sky-500 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-sky-600 transition">Twitter</a>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="bg-emerald-500 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-emerald-600 transition">WhatsApp</a>
            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-sky-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-sky-700 transition">Telegram</a>
        </div>

        @auth
            @can('update', $post)
                <div class="flex gap-2 pt-5 border-t border-slate-100">
                    <a href="{{ route('posts.edit', $post) }}" class="bg-[#1a3d7c] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#2a5bb0] transition">Edit Artikel</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-600 transition">Hapus</button>
                    </form>
                </div>
            @endcan
        @endauth

        <div class="pt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#1a3d7c] hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</article>

@if ($relatedPosts->count() > 0)
<section class="max-w-3xl mx-auto mt-10">
    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
        <span class="w-1.5 h-5 bg-[#d4a017] rounded"></span>
        Artikel Terkait
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($relatedPosts as $related)
            <a href="{{ route('posts.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition group">
                @if ($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-32 object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-32 unimed-gradient flex items-center justify-center text-white">
                        <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="font-bold text-slate-800 text-sm leading-snug mb-2 group-hover:text-[#1a3d7c] transition">{{ Str::limit($related->title, 60) }}</h3>
                    <p class="text-xs text-slate-400">{{ $related->views }} views</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

<section class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow-sm border border-slate-100 p-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
        <span class="w-1.5 h-5 bg-[#d4a017] rounded"></span>
        Komentar ({{ $post->comments->count() }})
    </h2>

    @auth
        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
            @csrf
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-full bg-[#1a3d7c] text-white flex items-center justify-center font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <textarea name="body" rows="3"
                              class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:border-[#1a3d7c] focus:ring-1 focus:ring-[#1a3d7c] focus:outline-none @error('body') border-red-500 @enderror"
                              placeholder="Tulis komentar Anda..."></textarea>
                    @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <button type="submit" class="mt-2 bg-[#1a3d7c] text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-[#2a5bb0] transition">
                        Kirim Komentar
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-8 text-sm text-slate-600">
            <a href="{{ route('login') }}" class="text-[#1a3d7c] font-semibold hover:underline">Masuk</a> untuk berkomentar.
        </div>
    @endauth

    <div class="space-y-5">
        @forelse ($post->comments as $comment)
            <div class="flex gap-3 pb-5 border-b border-slate-100 last:border-0">
                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold flex-shrink-0">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <strong class="text-slate-800 text-sm">{{ $comment->user->name }}</strong>
                            <span class="text-xs text-slate-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        @auth
                            @if (auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $comment->body }}</p>
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-center py-8 text-sm">Belum ada komentar. Jadilah yang pertama berkomentar.</p>
        @endforelse
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    async function toggle(url) {
        return await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        }).then(r => r.json());
    }

    const likeBtn = document.getElementById('likeBtn');
    if (likeBtn) likeBtn.addEventListener('click', async function() {
        @guest window.location.href = '{{ route('login') }}'; return; @endguest
        const data = await toggle(this.dataset.url);
        document.getElementById('likeCount').textContent = data.count;
        if (data.liked) {
            likeBtn.classList.add('bg-red-500', 'text-white', 'border-red-500');
            likeBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
        } else {
            likeBtn.classList.remove('bg-red-500', 'text-white', 'border-red-500');
            likeBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
        }
    });

    const bookmarkBtn = document.getElementById('bookmarkBtn');
    if (bookmarkBtn) bookmarkBtn.addEventListener('click', async function() {
        @guest window.location.href = '{{ route('login') }}'; return; @endguest
        const data = await toggle(this.dataset.url);
        document.getElementById('bookmarkCount').textContent = data.count;
        if (data.bookmarked) {
            bookmarkBtn.classList.add('bg-[#d4a017]', 'text-white', 'border-[#d4a017]');
            bookmarkBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
        } else {
            bookmarkBtn.classList.remove('bg-[#d4a017]', 'text-white', 'border-[#d4a017]');
            bookmarkBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
        }
    });
});
</script>
@endpush
@endsection