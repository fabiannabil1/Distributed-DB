@extends('layout.admin.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white rounded-xl shadow-md p-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Edit Artikel</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('artikel.update', $artikel->artikel_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <!-- Gambar -->
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>

               <!-- Preview gambar lama -->
                @if($artikel->gambar)
                    <img id="preview-lama" src="{{ asset('img/' . $artikel->gambar) }}" alt="Gambar Artikel"
                        class="w-full max-h-[400px] object-contain rounded border mb-2 shadow-sm">
                @endif

                <!-- Preview gambar baru -->
                <img id="preview-baru" src="#" class="w-full max-h-[400px] object-contain rounded border mb-2 hidden shadow-sm" alt="Preview Baru">


                <input type="file" id="gambar" name="gambar"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    accept="image/*">

            </div>

            <!-- Konten -->
            <div class="mb-4">
                <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                <textarea id="konten" name="konten" rows="6"
                          class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                          required>{{ old('konten', $artikel->konten) }}</textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="text-right">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Gambar Baru -->
@push('scripts')
<script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewBaru = document.getElementById('preview-baru');
        const previewLama = document.getElementById('preview-lama');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewBaru.src = e.target.result;
                previewBaru.classList.remove('hidden');
                if (previewLama) previewLama.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

@endsection
