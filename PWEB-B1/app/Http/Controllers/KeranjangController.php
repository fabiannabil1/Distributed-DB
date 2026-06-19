<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if($pelanggan){
            $items = DetailTransaksi::with('produk')
                ->where('pelanggan_id', auth()->guard('pelanggan')->id())
                ->where('isDraft', true)
                ->get();

            return view('Pelanggan.keranjang', compact('items'));
        }else{
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);

        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
        }

        $produk = Produk::findOrFail($request->produk_id);

        $existing = DetailTransaksi::where('produk_id', $produk->id)
            ->where('pelanggan_id', $pelanggan->pelanggan_id)
            ->where('isDraft', true)
            ->whereNull('transaksi_id')
            ->first();

        if ($existing) {
            $existing->increment('qty');
        } else {
            DetailTransaksi::create([
                'produk_id' => $produk->id,
                'qty' => 1,
                'harga' => $produk->harga,
                'pelanggan_id' => $pelanggan->pelanggan_id,
                'isDraft' => true,
                'transaksi_id' => null,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $item = DetailTransaksi::where('id', $id)
            ->where('isDraft', true)
            ->whereNull('transaksi_id')
            ->firstOrFail();

        $qty = $item->qty;

        if ($request->action === 'increase') {
            $qty++;
        } elseif ($request->action === 'decrease') {
            $qty = max(1, $qty - 1);
        } else {
            // fallback kalau user langsung input angka
            $request->validate([
                'qty' => 'required|integer|min:1',
            ]);
            $qty = $request->qty;
        }

        $item->update(['qty' => $qty]);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function destroy($id)
    {
        $item = DetailTransaksi::where('id', $id)
            ->where('isDraft', true)
            ->whereNull('transaksi_id')
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
