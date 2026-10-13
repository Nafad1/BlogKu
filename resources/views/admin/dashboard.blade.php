@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold text-red-600 mb-4">🔐 Admin Dashboard</h1>
    <p class="text-gray-600 mb-6">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <p class="text-red-700">Halaman ini hanya bisa diakses oleh user dengan role <strong>admin</strong>.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\User::count() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Total Post</p>
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Post::count() }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Total Kategori</p>
            <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Kembali ke Dashboard</a>
</div>
@endsection