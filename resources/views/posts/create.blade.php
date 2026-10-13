@extends('layouts.app')
@section('title', 'Tulis Artikel')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tulis Artikel Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Bagikan gagasan dan pengetahuan Anda</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:border-[#1a3d7c] focus:ring-1 focus:ring-[#1a3d7c] focus:outline-none @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul yang menarik">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                <select name="category_id" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:border-[#1a3d7c] focus:outline-none @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Isi Artikel</label>
                <textarea name="body" id="body" rows="10" class="w-full border border-slate-300 rounded-lg p-3 text-sm @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Sampul (Opsional)</label>
                <input type="file" name="image" class="w-full border border-slate-300 rounded-lg p-3 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1a3d7c] file:text-white file:font-semibold file:cursor-pointer hover:file:bg-[#2a5bb0]">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Publikasi</label>
                <select name="status" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:border-[#1a3d7c] focus:outline-none">
                    <option value="draft">Simpan sebagai Draft</option>
                    <option value="published">Publikasikan Sekarang</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-[#1a3d7c] text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-[#2a5bb0] transition">Simpan Artikel</button>
                <a href="{{ route('home') }}" class="bg-slate-100 text-slate-700 px-6 py-3 rounded-lg font-semibold text-sm hover:bg-slate-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#body').summernote({
            height: 400,
            placeholder: 'Tulis isi artikel di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });
    });
</script>
@endpush