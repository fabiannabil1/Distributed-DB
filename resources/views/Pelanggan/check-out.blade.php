@extends('layout.pelanggan.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Checkout Pembayaran</h1>

    @if ($items->isEmpty())
        <p class="text-gray-500">Keranjang kamu kosong.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
                    <div class="divide-y">
                        @foreach ($items as $item)
                            <div class="py-4 flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/images/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-16 h-16 object-cover rounded">
                                    <div>
                                        <h3 class="font-medium">{{ $item->produk->nama_produk }}</h3>
                                        <p class="text-gray-500 text-sm">Qty: {{ $item->qty }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">Rp{{ number_format($item->qty * $item->produk->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-4 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Ringkasan Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Penanganan</span>
                            <span>Rp{{ number_format($biayapenanganan, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span>Rp{{ number_format($total + $biayapenanganan, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form  action="{{ route('transaksi.create') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="total" id="total" value="{{ $total + $biayapenanganan }}">
                        <button id="btn-bayar" type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition duration-200">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <script>
        document.getElementById('btn-bayar').addEventListener('click', function(e) {
            e.preventDefault();

            const total = document.getElementById('total')?.value;
            const token = document.getElementById('csrf_token')?.value;

            if (!total || !token) {
                alert("Data tidak lengkap.");
                return;
            }

            fetch("{{ route('transaksi.create') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        total: total
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");
                                window.location.href = "/transaksi";
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran!");
                                window.location.href = "/transaksi";
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                console.error(result);
                            }
                        });
                    } else {
                        alert("Gagal mendapatkan Snap Token.");
                    }
                })
                .catch(error => {
                    console.error("AJAX Error:", error);
                });
        });
    </script>
</div>
@endsection
