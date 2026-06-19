{{-- resources/views/layout/admin/components/katalog-tambah.blade.php --}}
@extends('Layout.admin.app')

@section('title', 'Tambah Produk')

@section('content')
<section class="bg-white py-12">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-green-700 mb-6">Tambah Produk Baru</h1>

        <form action="{{ route('katalog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="nama_produk" class="block font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="w-full border rounded-lg px-4 py-2 mt-1" required>
                @error('nama_produk')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full border rounded-lg px-4 py-2 mt-1" required></textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block font-medium text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full border rounded-lg px-4 py-2 mt-1" required>
                @error('harga')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok" class="w-full border rounded-lg px-4 py-2 mt-1" required>
                @error('stok')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gambar" class="block font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="w-full mt-1" accept="image/*" onchange="previewImage(event)">
                <img id="preview" class="mt-4 w-40 h-40 object-cover rounded" style="display: none;" />
                @error('gambar')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('katalog.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</section>
@endsection
