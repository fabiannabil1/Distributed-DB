<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempatSampah;

class TempatSampahController extends Controller
{
    // Ambil semua status tempat sampah (untuk polling via JS)
    public function getStatus()
    {
        // Gunakan nama kolom yang sesuai di database kamu
        $data = TempatSampah::select('tempat_sampah_id', 'status_penuh')->get();

        return response()->json($data);
    }

    // Update status tempat sampah via AJAX (POST)
    public function updateStatus(Request $request)
    {
        $request->validate([
            'tempat_sampah_id' => 'required|integer',
            'status_penuh' => 'required|string|max:50',
        ]);

        $tempatSampah = TempatSampah::find($request->tempat_sampah_id);

        if (!$tempatSampah) {
            return response()->json(['message' => 'Tempat sampah tidak ditemukan'], 404);
        }

        $tempatSampah->status_penuh = $request->status_penuh;
        $tempatSampah->save();

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }
}
