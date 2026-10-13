@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div>
            <h1 class="text-xl font-bold text-slate-800">Admin Dashboard</h1>
            <p class="text-sm text-slate-500">Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>
        </div>
    </div>

    <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm">
        Halaman ini hanya bisa diakses oleh pengguna dengan role <strong>admin</strong>.
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total User</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ \App\Models\User::count() }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Post</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ \App\Models\Post::count() }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-lg p-5">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Kategori</p>
            <p class="text-2xl font-bold text-[#1a3d7c]">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="inline-block bg-slate-100 text-slate-700 px-6 py-3 rounded-lg font-semibold text-sm hover:bg-slate-200 transition">Kembali ke Dashboard</a>
</div>
@endsection