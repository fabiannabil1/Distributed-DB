<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\StatusTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class TransaksiController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $admin = Auth::guard('admin')->user();

        if ($pelanggan) {
            $transaksiPelangganList = Transaksi::where('pelanggan_id', $pelanggan->pelanggan_id)->get();

            return view('Pelanggan.transaksi', compact('transaksiPelangganList'));
        } elseif ($admin) {
            $statusList = StatusTransaksi::whereIn('id', [3, 4])->get();
            $transaksiList = Transaksi::orderBy('created_at', 'desc')->get();

            return view('Admin.transaksi', compact('transaksiList', 'statusList'));
        } else {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function checkoutPreview()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $items = DetailTransaksi::where('pelanggan_id', $pelanggan->pelanggan_id)
        ->where('isDraft', true)
        ->with('produk')
        ->get();

        $total = $items->sum(function($item) {
            return $item->qty * $item->produk->harga;
        });

        $biayapenanganan = 3000;
        $snapToken = session('snapToken');

        return view('pelanggan.check-out', compact('items', 'total', 'biayapenanganan', 'snapToken'));
    }

    public function create()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $items = DetailTransaksi::where('pelanggan_id', $pelanggan->pelanggan_id)
            ->where('isDraft', true)
            ->with('produk')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $total = $items->sum(function($item) {
            return $item->qty * $item->produk->harga;
        });

        $biayapenanganan = 3000;
        $grandtotal = $total + $biayapenanganan;
        $order_id = 'ORDER-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $grandtotal,
            ],
            'customer_details' => [
                'first_name' => $pelanggan->nama_lengkap,
                'email' => $pelanggan->email,
                'phone' => $pelanggan->nomor_telepon,
                'shipping_address' => [
                    'address' => 'tes',
                ],
            ]
        ];

        $transaksi = Transaksi::create([
            'total' => $grandtotal,
            'midtrans_order_id' => $order_id,
            'pelanggan_id' => $pelanggan->pelanggan_id,
            'status_transaksi_id' => 2,
            'created_at' => now()
        ]);

        foreach ($items as $item) {
            $item->transaksi_id = $transaksi->id;
            $item->isDraft = false;
            $item->save();

            $produk = $item->produk;
            $produk->stok -= $item->qty;
            $produk->save();
        }

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        DB::commit();

        // Simpan ke session untuk nanti ditampilkan
        session(['snapToken' => $snapToken]);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with([
            'detailTransaksis.produk',
            'status',
            'pelanggan'
        ])->findOrFail($id);

        return response()->json([
            'nama' => $transaksi->pelanggan->nama_lengkap ?? '-',
            'midtrans_order_id' => $transaksi->midtrans_order_id ?? '-',
            'tanggal' => \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y'),
            'total' => number_format($transaksi->total, 0, ',', '.'),
            'alamat' => $transaksi->pelanggan->alamat ?? '-',
            'produk' => $transaksi->detailTransaksis->map(function ($d) {
                return [
                    'nama' => $d->produk->nama_produk ?? 'Produk tidak ditemukan',
                    'qty' => $d->qty,
                    'harga' => number_format($d->harga, 0, ',', '.'),
                ];
            }),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:status_transaksis,id',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_transaksi_id = $request->status_id;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function batalkanOrder(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $batasWaktu = Carbon::parse($transaksi->created_at)->addMinutes(120);

        if (now()->lessThan($batasWaktu)) {
            return back()->with('error', 'Transaksi hanya bisa dibatalkan setelah 120 menit.');
        }

        if (strtolower($transaksi->status->status) !== 'menunggu pembayaran') {
            return back()->with('error', 'Transaksi hanya bisa dibatalkan jika masih berstatus menunggu pembayaran.');
        }

        DB::beginTransaction();
        try {
            $transaksi->status_transaksi_id = 1;
            $transaksi->catatan = $request->catatan;
            $transaksi->save();

            DB::commit();
            return back()->with('success', 'Transaksi berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    public function setSelesai($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (strtolower($transaksi->status->status) === 'dikirim') {
            $transaksi->status_transaksi_id = 5;
            $transaksi->save();
            return redirect()->back()->with('success', 'Transaksi berhasil diselesaikan.');
        }

        return redirect()->back()->with('error', 'Transaksi tidak bisa diselesaikan.');
    }
}
