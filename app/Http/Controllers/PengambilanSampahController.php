<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPengambilanSampah;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Illuminate\Http\JsonResponse;

class PengambilanSampahController extends Controller
{
    public function tambahEmber(Request $request): JsonResponse
    {
        $pelangganIds = json_decode($request->input('pelanggan_ids'), true);

        if (!$pelangganIds || !is_array($pelangganIds)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada pelanggan yang dipilih.'], 400);
        }

        $updated = 0;
        foreach ($pelangganIds as $id) {
            $pelanggan = Pelanggan::with(['pengambilanSampah', 'tempatSampah'])->find($id);

            if ($pelanggan && $pelanggan->pengambilanSampah) {
                $pengambilan = $pelanggan->pengambilanSampah;

                // Tambah jumlah ember
                $pengambilan->jumlah_ember += 1;
                $pengambilan->save();

                // Buat detail pengambilan
                DetailPengambilanSampah::create([
                    'pengambilan_id' => $pengambilan->pengambilan_id,
                    'tanggal_pengambilan' => now(),
                    'admin_id' => Auth::guard('admin')->id(),
                ]);

                // Ubah status_penuh menjadi 'kosong' di tempat sampah
                if ($pelanggan->tempatSampah) {
                    $pelanggan->tempatSampah->status_penuh = 'kosong';
                    $pelanggan->tempatSampah->save();
                }

                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil menambahkan ember($updated pelanggan diproses).",
        ]);
    }
}
