@extends('Layout.admin.app')

@section('title', 'Transaksi')

@section('content')
<div x-data="{ open: false, detail: {} }" class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

    @if ($transaksiList->isEmpty())
        <p class="text-gray-500">Belum ada transaksi.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2 border">#</th>
                        <th class="text-left px-4 py-2 border">Order ID</th>
                        <th class="text-left px-4 py-2 border">Tanggal</th>
                        <th class="text-left px-4 py-2 border">Waktu</th>
                        <th class="text-left px-4 py-2 border">Total</th>
                        <th class="text-left px-4 py-2 border">Status</th>
                        <th class="text-left px-4 py-2 border">Aksi</th>
                        <th class="text-left px-4 py-2 border">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksiList as $index => $transaksi)
                        <tr class="hover:bg-green-50 transition-colors border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $transaksi->midtrans_order_id ?? '-' }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('H:i:s') }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($transaksi->status_transaksi_id == 1) bg-red-200 text-red-800
                                    @elseif ($transaksi->status_transaksi_id == 2) bg-yellow-200 text-yellow-800
                                    @elseif ($transaksi->status_transaksi_id == 3 || $transaksi->status_transaksi_id == 5) bg-green-200 text-green-800
                                    @else bg-gray-200 text-gray-800
                                    @endif">
                                    {{ strtolower($transaksi->status->status ?? '-') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center space-y-2">
                                <div class="flex justify-center gap-2">
                                    @php
                                        $status = strtolower($transaksi->status->status ?? '');
                                        $bisaDibatalkan = \Carbon\Carbon::parse($transaksi->created_at)->addMinutes(120)->isPast();
                                        $isDitunda = $status === 'menunggu pembayaran';
                                        $batalDisabled = !$bisaDibatalkan || !$isDitunda;
                                    @endphp

                                    @if(!in_array($status, ['gagal', 'selesai', 'dikirim']))
                                        <button type="button"
                                            data-modal-target="modal-batal-{{ $transaksi->id }}"
                                            class="text-red-500 hover:text-red-700 disabled:opacity-40 disabled:cursor-not-allowed"
                                            title="Batalkan"
                                            @if($batalDisabled) disabled @endif>
                                            <i data-feather="x-circle"></i>
                                        </button>

                                        {{-- Modal Konfirmasi Batal --}}
                                        <div id="modal-batal-{{ $transaksi->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50 px-4">
                                            <div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-6 relative animate-fade-in-down">
                                                <button data-close-modal class="absolute top-3 right-4 text-gray-600 hover:text-red-500 text-3xl font-bold">&times;</button>
                                                <h3 class="text-xl font-semibold text-red-600 mb-4 border-b pb-2">Konfirmasi Pembatalan</h3>

                                                <form action="{{ route('transaksi.batalkan', $transaksi->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-4">
                                                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan</label>
                                                        <textarea name="catatan" rows="3" required
                                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500"
                                                            placeholder="Contoh: Pembeli tidak melakukan pembayaran dalam waktu yang ditentukan."></textarea>
                                                    </div>
                                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white rounded-lg py-2 text-sm">
                                                        Batalkan Transaksi
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <button type="button"
                                            data-modal-target="modal-edit-{{ $transaksi->id }}"
                                            class="w-5 h-5 mt-0.5 aspect-square flex items-center justify-center rounded-full ring-2 ring-emerald-600 text-emerald-600 hover:ring-emerald-700 transition"
                                            title="Edit Status">
                                            <i data-feather="edit-3" class="w-3 h-3"></i>
                                        </button>

                                        {{-- Modal Edit Status --}}
                                        <div id="modal-edit-{{ $transaksi->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50 px-4">
                                            <div class="bg-white rounded-3xl shadow-xl max-w-md w-full p-6 relative animate-fade-in-down">
                                                <button data-close-modal class="absolute top-3 right-4 text-gray-600 hover:text-red-500 text-3xl font-bold">&times;</button>
                                                <h3 class="text-xl font-semibold text-emerald-600 mb-4 border-b pb-2">Ubah Status Transaksi</h3>

                                                <form action="{{ route('transaksi.updateStatus', $transaksi->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status_id" class="w-full border rounded-lg px-3 py-2 text-sm text-gray-700">
                                                        @foreach($statusList as $status)
                                                            <option value="{{ $status->id }}" {{ $transaksi->status_transaksi_id == $status->id ? 'selected' : '' }}>
                                                                {{ ucfirst($status->status) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="mt-4 w-full bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg py-2 text-sm">
                                                        Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <button
                                    @click="fetch(`/admin/transaksi/{{ $transaksi->id }}`)
                                        .then(res => res.json())
                                        .then(data => { detail = data; open = true; })"
                                    class="mt-2 px-3 py-1 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">
                                    Detail
                                </button>
                            </td>
                            <td class="px-4 py-2">{{ $transaksi->catatan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-600 hover:text-red-600 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold text-green-600 mb-4 border-b pb-2">Detail Transaksi</h2>
            <table class="w-full text-sm space-y-2">
                <tr>
                    <td class="font-semibold w-1/3">Nama</td>
                    <td x-text="detail.nama ?? '-'"></td>
                </tr>
                <tr>
                    <td class="font-semibold">Order ID</td>
                    <td x-text="detail.midtrans_order_id ?? '-'"></td>
                </tr>
                <tr>
                    <td class="font-semibold">Tanggal</td>
                    <td x-text="detail.tanggal ?? '-'"></td>
                </tr>
                <tr>
                    <td class="font-semibold align-top">Alamat</td>
                    <td x-text="detail.alamat ?? '-'"></td>
                </tr>
                <tr>
                    <td class="font-semibold align-top">Produk</td>
                    <td>
                        <template x-if="detail.produk && detail.produk.length">
                            <ul class="text-sm text-gray-800 space-y-1" x-show="detail.produk">
                                <template x-for="item in detail.produk" :key="item.nama">
                                    <li class="flex justify-between">
                                        <span x-text="item.nama"></span>
                                        <span x-text="item.qty + 'x'"></span>
                                        <span x-text="'Rp' + item.harga"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>
                        <template x-if="!detail.produk || detail.produk.length === 0">
                            <span>-</span>
                        </template>
                    </td>
                </tr>
                <tr>
                    <td class="font-semibold">Biaya Penanganan</td>
                    <td class="text-right">Rp3.000</td>
                </tr>
                <tr>
                    <td class="font-semibold">Total</td>
                    <td class="text-right" x-text="'Rp' + (detail.total ?? '-')"></td>
                </tr>
            </table>
            <div class="text-right mt-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();

        // Modal open/close logic
        document.querySelectorAll("[data-modal-target]").forEach(btn => {
            btn.addEventListener("click", () => {
                const target = btn.getAttribute("data-modal-target");
                const modal = document.getElementById(target);
                if (modal) modal.classList.remove("hidden");
            });
        });

        document.querySelectorAll("[data-close-modal]").forEach(btn => {
            btn.addEventListener("click", () => {
                btn.closest(".fixed").classList.add("hidden");
            });
        });
    });
</script>
@endsection
