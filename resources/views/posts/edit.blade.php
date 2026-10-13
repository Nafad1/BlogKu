@extends('layouts.app')
@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Artikel</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-2">Judul</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border-2 border-gray-300 rounded-lg p-3 @error('title') border-red-500 @enderror">
            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Kategori</label>
            <select name="category_id" class="w-full border-2 border-gray-300 rounded-lg p-3">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Isi Artikel</label>
            <textarea name="body" id="body" rows="10" class="w-full border-2 border-gray-300 rounded-lg p-3 @error('body') border-red-500 @enderror">{{ old('body', $post->body) }}</textarea>
            @error('body')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Gambar</label>
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="w-40 rounded mb-2">
            @endif
            <input type="file" name="image" class="w-full border-2 border-gray-300 rounded-lg p-3">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Status</label>
            <select name="status" class="w-full border-2 border-gray-300 rounded-lg p-3">
                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publish</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600">Update</button>
            <a href="{{ route('posts.show', $post->slug) }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600">Batal</a>
        </div>
    </form>
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