@extends('layouts.app')
@section('title', 'Profil ' . $user->name)

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 mb-8">
    <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
            <p class="text-gray-500 mt-1">{{ $user->email }}</p>
            <span class="inline-block mt-2 text-xs font-semibold text-white bg-blue-600 px-3 py-1 rounded-full uppercase">
                {{ $user->role }}
            </span>

            @auth
                @if (auth()->id() !== $user->id)
                    <button id="followBtn"
                            data-url="{{ route('authors.follow', $user) }}"
                            class="mt-3 px-5 py-2 rounded-lg font-semibold transition block md:inline-block {{ auth()->user()->follows($user->id) ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                        <span id="followText">{{ auth()->user()->follows($user->id) ? 'Following' : 'Follow' }}</span>
                        <span id="followCount" class="ml-2 text-sm">({{ $user->followers()->count() }})</span>
                    </button>
                @endif
            @endauth
        </div>
        <div class="flex gap-6 text-center">
            <div>
                <p class="text-2xl font-bold text-blue-600">{{ $totalPosts }}</p>
                <p class="text-xs text-gray-500 uppercase">Artikel</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-600">{{ $totalViews }}</p>
                <p class="text-xs text-gray-500 uppercase">Views</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-purple-600">{{ $user->followers()->count() }}</p>
                <p class="text-xs text-gray-500 uppercase">Followers</p>
            </div>
        </div>
    </div>
</div>

<h2 class="text-2xl font-bold text-gray-800 mb-4">Artikel oleh {{ $user->name }}</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <span>👁️ {{ $post->views }}</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </article>
    @empty
        <p class="col-span-3 text-center py-12 text-gray-500">Belum ada artikel.</p>
    @endforelse
</div>

<div class="mt-8">{{ $posts->links() }}</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const followBtn = document.getElementById('followBtn');
    if (!followBtn) return;

    followBtn.addEventListener('click', async function() {
        const url = this.dataset.url;
        const token = '{{ csrf_token() }}';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
        });

        const data = await response.json();
        document.getElementById('followCount').textContent = '(' + data.count + ')';
        document.getElementById('followText').textContent = data.followed ? 'Following' : 'Follow';

        if (data.followed) {
            followBtn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            followBtn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
        } else {
            followBtn.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            followBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
        }
    });
});
</script>
@endpush
@endsection