@extends('layouts.app')
@section('title', 'Profil ' . $user->name)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="unimed-gradient h-32"></div>
    <div class="px-8 pb-8 -mt-12">
        <div class="flex flex-col md:flex-row items-center md:items-end gap-6">
            <div class="w-24 h-24 rounded-2xl bg-white border-4 border-white shadow-md flex items-center justify-center text-[#1a3d7c] text-4xl font-extrabold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="flex-1 text-center md:text-left md:pb-1">
                <h1 class="text-2xl font-bold text-slate-800">{{ $user->name }}</h1>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                <span class="inline-block mt-2 text-xs font-semibold text-[#1a3d7c] bg-[#1a3d7c]/10 px-3 py-1 rounded-full uppercase tracking-wide">{{ $user->role }}</span>
            </div>
            @auth
                @if (auth()->id() !== $user->id)
                    <button id="followBtn" data-url="{{ route('authors.follow', $user) }}"
                            class="px-6 py-2.5 rounded-lg font-semibold text-sm transition border {{ auth()->user()->follows($user->id) ? 'bg-white text-slate-700 border-slate-300 hover:border-slate-400' : 'bg-[#1a3d7c] text-white border-[#1a3d7c] hover:bg-[#2a5bb0]' }}">
                        <span id="followText">{{ auth()->user()->follows($user->id) ? 'Mengikuti' : 'Ikuti' }}</span>
                        <span id="followCount" class="ml-1 opacity-80">({{ $user->followers()->count() }})</span>
                    </button>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-3 gap-4 mt-8 pt-6 border-t border-slate-100">
            <div class="text-center">
                <p class="text-2xl font-bold text-[#1a3d7c]">{{ $totalPosts }}</p>
                <p class="text-xs text-slate-500 uppercase tracking-wide mt-1">Artikel</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-[#1a3d7c]">{{ $totalViews }}</p>
                <p class="text-xs text-slate-500 uppercase tracking-wide mt-1">Views</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-[#1a3d7c]">{{ $user->followers()->count() }}</p>
                <p class="text-xs text-slate-500 uppercase tracking-wide mt-1">Followers</p>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
    <span class="w-1.5 h-5 bg-[#d4a017] rounded"></span>
    Artikel oleh {{ $user->name }}
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                <p class="text-sm text-slate-500 mb-4">{{ Str::limit(strip_tags($post->body), 80) }}</p>
                <div class="flex justify-between items-center text-xs text-slate-400 pt-3 border-t border-slate-100">
                    <span>{{ $post->views }} views</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </article>
    @empty
        <p class="col-span-3 text-center py-12 text-slate-500 bg-white rounded-xl border border-dashed border-slate-300">Belum ada artikel.</p>
    @endforelse
</div>

<div class="mt-8">{{ $posts->links() }}</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const followBtn = document.getElementById('followBtn');
    if (!followBtn) return;

    followBtn.addEventListener('click', async function() {
        const response = await fetch(this.dataset.url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        });
        const data = await response.json();
        document.getElementById('followCount').textContent = '(' + data.count + ')';
        document.getElementById('followText').textContent = data.followed ? 'Mengikuti' : 'Ikuti';

        if (data.followed) {
            followBtn.classList.remove('bg-[#1a3d7c]', 'text-white', 'border-[#1a3d7c]', 'hover:bg-[#2a5bb0]');
            followBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-300', 'hover:border-slate-400');
        } else {
            followBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300', 'hover:border-slate-400');
            followBtn.classList.add('bg-[#1a3d7c]', 'text-white', 'border-[#1a3d7c]', 'hover:bg-[#2a5bb0]');
        }
    });
});
</script>
@endpush
@endsection