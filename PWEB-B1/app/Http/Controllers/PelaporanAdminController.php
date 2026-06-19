<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonImmutable;


class PelaporanAdminController extends Controller
{
    public function pengambilanPerBulan()
    {
        Carbon::setLocale('id');

        $data_laporan = DB::table('detail_pengambilan_sampahs')
        ->selectRaw("TO_CHAR(tanggal_pengambilan, 'YYYY-MM') AS bulan, COUNT(*) AS jumlah_ember")
        ->groupByRaw("TO_CHAR(tanggal_pengambilan, 'YYYY-MM')")
        ->orderByRaw("TO_CHAR(tanggal_pengambilan, 'YYYY-MM')")
        ->get();

        return view('Admin.pelaporan', compact('data_laporan'));
    }
}
