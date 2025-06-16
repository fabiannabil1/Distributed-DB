<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Berlangganan;
use Midtrans\Snap;

class BerlanggananController extends Controller
{
    // Mendapatkan Snap Token dari Midtrans
    public function create(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $order_id = uniqid(); // Bisa diganti dengan format khusus jika perlu

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => 80000,
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap,
                'email' => $user->email,
                'phone' => $user->nomor_telepon,
            ]
        ];

        // Ambil Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Return sebagai JSON ke frontend (JavaScript)
        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $order_id
        ]);
    }

    // Menyimpan data berlangganan setelah pembayaran sukses
    public function store(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validasi dasar
        $request->validate([
            'order_id' => 'required|string',
        ]);

        // Simpan ke tabel berlangganan
        Berlangganan::create([
            'pelanggan_id' => $user->pelanggan_id,
            'biaya_berlangganan' => 80000,
            'midtrans_order_id' => $request->order_id
        ]);

        // Perbarui status pelanggan
        DB::table('pelanggans')
            ->where('pelanggan_id', $user->pelanggan_id)
            ->update([
                'status_berlangganan' => 'Aktif',
                'tanggal_berlangganan' => now(),
            ]);

        return response()->json(['status' => 'success']);
    }
}
