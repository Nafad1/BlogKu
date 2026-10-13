@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-gray-600">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>
    <p class="text-sm text-gray-500 mt-1">Role: {{ auth()->user()->role }}</p>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg inline-block hover:bg-blue-700">+ Tulis Artikel Baru</a>
        <a href="{{ route('home') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg inline-block hover:bg-gray-600">Lihat Beranda</a>
    </div>

    @if (auth()->user()->isAdmin())
        <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
            <p class="text-red-700 font-semibold">Anda login sebagai Admin</p>
            <a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:underline text-sm">Buka Admin Panel →</a>
        </div>
    @endif
</div>
@endsection