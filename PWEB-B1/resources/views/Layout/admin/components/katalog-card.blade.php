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
            @if ($produk->isActive == 0)
                <form action="{{ route('katalog.restore', $produk->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengaktifkan produk ini?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="flex items-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                        <i data-feather="refresh-cw" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Restore</span>
                    </button>
                </form>
            @else
                <div class="flex gap-2">
                    <form action="{{ route('katalog.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menonaktifkan produk ini? Anda dapat memulihkannya nanti.')">
                        @csrf
                        @method('DELETE')
                        <button class="flex items-center gap-1 text-red-600 hover:text-white border border-red-600 px-3 py-1 rounded-md hover:bg-red-600 transition">
                            <i data-feather="trash-2" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Hapus</span>
                        </button>
                    </form>

                    <button onclick="openEditModal({{ $produk->id }})" class="flex items-center gap-1 bg-green-600 hover:text-green-600 text-white border border-green-600 px-3 py-1 rounded-md hover:bg-white transition">
                        <i data-feather="edit" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Edit</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- Modal edit --}}
        <div id="editModal-{{ $produk->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-green-700">Edit Produk</h2>
                <form id="editForm-{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" id="editNama-{{ $produk->id }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Harga</label>
                        <input type="number" name="harga" id="editHarga-{{ $produk->id }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Stok</label>
                        <input type="number" name="stok" id="editStok-{{ $produk->id }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Deskripsi</label>
                        <textarea name="deskripsi" id="editDeskripsi-{{ $produk->id }}" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                    </div>
                    <div class="mb-4 text-left">
                        <label class="block text-sm text-gray-700 mb-1">Gambar</label>
                        <img id="previewGambar-{{ $produk->id }}" src="{{ asset('storage/images/' . $produk->gambar) }}" alt="Preview Gambar" class="w-full h-40 object-contain rounded border mb-2">
                        <input type="file" name="gambar" accept="image/*"
                            @change="updatePreview"
                            class="w-full border rounded p-2">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeEditModal({{ $produk->id }})" class="px-4 py-2 rounded border border-gray-400 text-gray-600 hover:bg-gray-100">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal detail --}}
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
</div>

<script>
    function openEditModal(id) {
        fetch(`/katalog/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById(`editNama-${id}`).value = data.nama_produk;
                document.getElementById(`editHarga-${id}`).value = data.harga;
                document.getElementById(`editStok-${id}`).value = data.stok;
                document.getElementById(`editDeskripsi-${id}`).value = data.deskripsi ?? '';
                document.getElementById(`editForm-${id}`).action = `/katalog/${id}`;
                document.getElementById(`editModal-${id}`).classList.remove('hidden');
            });
    }

    function closeEditModal(id) {
        document.getElementById(`editModal-${id}`).classList.add('hidden');
    }

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

