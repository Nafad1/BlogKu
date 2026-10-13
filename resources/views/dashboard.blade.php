@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
        <div class="w-14 h-14 rounded-xl unimed-gradient text-white flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-slate-500">Role: <span class="font-semibold text-[#1a3d7c] uppercase">{{ auth()->user()->role }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Artikel</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ auth()->user()->posts()->count() }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Views</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ auth()->user()->posts()->sum('views') }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Bookmark</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ auth()->user()->bookmarks()->count() }}</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 bg-[#1a3d7c] text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-[#2a5bb0] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tulis Artikel Baru
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-6 py-3 rounded-lg font-semibold text-sm hover:bg-slate-200 transition">
            Lihat Beranda
        </a>
    </div>

    @if (auth()->user()->isAdmin())
        <div class="mt-6 p-5 bg-[#1a3d7c]/5 border-l-4 border-[#1a3d7c] rounded-r-lg">
            <p class="text-sm font-semibold text-[#1a3d7c]">Anda login sebagai Administrator</p>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-[#1a3d7c] hover:underline mt-1 inline-block">Buka Admin Panel &rarr;</a>
        </div>
    @endif
</div>
@endsection