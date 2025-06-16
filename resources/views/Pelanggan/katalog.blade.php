@extends('layout.pelanggan.app')

@section('title', 'Katalog')

@section('content')
<section class="bg-white py-12">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-green-700">Produk RePonik</h1>
            <a href="{{ route('keranjang.index') }}" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i data-feather="shopping-bag" class="w-5 h-5"></i>
                <span>Lihat Keranjang</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($produkListActive as $produk)
                <div class="bg-green-50 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/images/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-green-800 mb-1">
                            {{ $produk->nama_produk }}
                        </h2>
                        <p class="text-green-700 font-medium mb-4">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>

                        <div class="flex justify-between items-center">
                            <button onclick="openDetailModal({{ $produk->id }})" class="flex items-center gap-1 bg-white border border-green-600 text-green-700 px-3 py-1 rounded-md hover:bg-green-100 transition">
                                <i data-feather="info" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Detail</span>
                            </button>
                            <form action="{{ route('keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <button type="submit" class="flex items-center gap-1 bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition">
                                    <i data-feather="shopping-cart" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div id="detailModal-{{ $produk->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
                            <h2 class="text-2xl font-bold text-green-700 mb-4">Detail Produk</h2>
                            <img id="detailGambar-{{ $produk->id }}" src="" class="w-full h-48 object-contain rounded border mb-4" alt="Gambar Produk">
                            <p><strong>Nama Produk:</strong> <span id="detailNama-{{ $produk->id }}"></span></p>
                            <p><strong>Harga:</strong> Rp <span id="detailHarga-{{ $produk->id }}"></span></p>
                            <p><strong>Stok:</strong> <span id="detailStok-{{ $produk->id }}"></span></p>
                            <p><strong>Deskripsi:</strong></p>
                            <p id="detailDeskripsi-{{ $produk->id }}" class="whitespace-pre-line"></p>

                            <button onclick="closeDetailModal({{ $produk->id }})" class="absolute top-3 right-4 text-gray-500 hover:text-red-500">
                                <i data-feather="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        function openDetailModal(id) {
            fetch(`/katalog/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`detailNama-${id}`).textContent = data.nama_produk;
                    document.getElementById(`detailHarga-${id}`).textContent = parseInt(data.harga).toLocaleString('id-ID');
                    document.getElementById(`detailStok-${id}`).textContent = data.stok;
                    document.getElementById(`detailDeskripsi-${id}`).textContent = data.deskripsi ?? '-';
                    document.getElementById(`detailGambar-${id}`).src = `/storage/images/${data.gambar}`;
                    document.getElementById(`detailModal-${id}`).classList.remove('hidden');
                });
        }

        function closeDetailModal(id) {
            document.getElementById(`detailModal-${id}`).classList.add('hidden');
        }
    </script>
</section>
@endsection
