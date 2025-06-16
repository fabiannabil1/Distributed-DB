@extends('layout.pelanggan.app')

@section('title', 'Keranjang')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

    @if ($items->isEmpty())
        <p class="text-gray-500">Keranjang kamu kosong.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Produk</th>
                        <th class="px-4 py-2">Qty</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Subtotal</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-3 flex items-center space-x-4">
                                <img src="{{ asset('storage/images/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-16 h-16 object-cover rounded">
                                <span>{{ $item->produk->nama_produk }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-gray-300 rounded">-</button>
                                    <span class="w-12 text-center">{{ $item->qty }}</span>                                    <button type="submit" name="action" value="increase" class="px-2 py-1 bg-gray-300 rounded">+</button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                Rp{{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('checkout.preview') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lanjut ke Pembayaran</a>
        </div>
    @endif
</div>
@endsection
