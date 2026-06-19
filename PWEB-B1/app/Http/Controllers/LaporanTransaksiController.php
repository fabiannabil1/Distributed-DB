<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $totalPemasukan = Transaksi::whereIn('status_transaksi_id', [3, 4, 5])->sum('total');

        $totalOrder = Transaksi::whereIn('status_transaksi_id', [3, 4, 5])->count();

        $bulanList = collect(range(1, 12))->map(fn($b) =>
            Carbon::create()->month($b)->translatedFormat('F')
        );

        $grafikBulanan = Transaksi::selectRaw('EXTRACT(MONTH FROM created_at)::integer as bulan, SUM(total) as total')
            ->whereIn('status_transaksi_id', [3, 4, 5])
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan');

        $dataGrafik = collect(range(1, 12))->map(fn($b) => $grafikBulanan->get($b, 0));

        $transaksiPerTanggal = Transaksi::selectRaw('created_at::date as tanggal, SUM(total) as total_rupiah')
            ->whereIn('status_transaksi_id', [3, 4, 5])
            ->groupBy(DB::raw('created_at::date'))
            ->orderBy('tanggal')
            ->get();

        return view('Admin.laporan-transaksi', [
            'admin' => $admin,
            'totalPemasukan' => $totalPemasukan,
            'totalOrder' => $totalOrder,
            'bulanList' => $bulanList,
            'dataGrafik' => $dataGrafik,
            'transaksiPerTanggal' => $transaksiPerTanggal,
        ]);
    }
}
