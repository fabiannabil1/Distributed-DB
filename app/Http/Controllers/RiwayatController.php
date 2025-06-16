<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\DetailPengambilanSampah;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $riwayat = DetailPengambilanSampah::with(['admin', 'pengambilan'])
            ->whereHas('pengambilan', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->pelanggan_id);
            })
            ->orderBy('tanggal_pengambilan', 'desc')
            ->get();

        $totalPoin = $pelanggan->pengambilanSampah->jumlah_ember ?? 0;
        $tanggalMulai = Carbon::parse($pelanggan->tanggal_berlangganan)->startOfDay();
        $hariBerjalan = $tanggalMulai->diffInDays(Carbon::now()->startOfDay());
        $sisaHari = max(0, 30 - $hariBerjalan);

        return view('pelanggan.riwayat', compact('pelanggan', 'riwayat', 'totalPoin', 'sisaHari'));
    }
}
