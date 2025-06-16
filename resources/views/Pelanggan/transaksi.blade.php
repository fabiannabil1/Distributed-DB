@extends('layout.pelanggan.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div x-data="{ open: false, detail: {} }" class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

    @if ($transaksiPelangganList->isEmpty())
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
                        <th class="text-left px-4 py-2 border">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksiPelangganList as $index => $transaksi)
                        @php
                            $status = strtolower($transaksi->status->status ?? '');
                        @endphp
                        <tr class="hover:bg-green-50 transition-colors border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $transaksi->midtrans_order_id ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $transaksi->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $transaksi->created_at->format('H:i:s') }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($transaksi->status_transaksi_id == 1) bg-red-200 text-red-800
                                    @elseif ($transaksi->status_transaksi_id == 2) bg-yellow-200 text-yellow-800
                                    @elseif (in_array($transaksi->status_transaksi_id, [3,5])) bg-green-200 text-green-800
                                    @else bg-gray-200 text-gray-800
                                    @endif">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex flex-col items-center space-y-2">

                                    @if (!in_array($transaksi->status_transaksi_id, [1, 2, 5]))
                                        <form action="{{ route('transaksi.selesai', $transaksi->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                @if ($status !== 'dikirim') disabled @endif
                                                class="flex items-center gap-1 px-4 py-2 rounded-lg text-base font-semibold transition
                                                    @if ($status === 'dikirim')
                                                        bg-green-600 text-white hover:bg-green-700
                                                    @else
                                                        bg-gray-200 text-gray-400 cursor-not-allowed
                                                    @endif">
                                                <i data-feather="check"></i>
                                                <span>Selesai</span>
                                            </button>
                                        </form>
                                    @endif

                                    <button
                                        @click="
                                            fetch('{{ route('transaksi.detail', $transaksi->id) }}')
                                            .then(res => res.json())
                                            .then(data => {
                                                detail = data;
                                                open = true;
                                                $nextTick(() => feather.replace());
                                            })
                                            .catch(err => {
                                                alert('Gagal mengambil detail transaksi.');
                                                console.error(err);
                                            })
                                        "
                                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-base font-semibold bg-green-500 text-white hover:bg-green-600 transition"
                                    >
                                        <i data-feather="info"></i>
                                        <span>Detail</span>
                                    </button>

                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $transaksi->catatan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal Detail -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-600 hover:text-red-600 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold text-green-600 mb-4 border-b pb-2">Detail Transaksi</h2>
            <table class="w-full text-sm">
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
                            <ul class="text-sm text-gray-800 space-y-1">
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
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>
@endsection
