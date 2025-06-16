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
        ->selectRaw("DATE_FORMAT(tanggal_pengambilan, '%Y-%m') AS bulan, COUNT(*) AS jumlah_ember")
        ->groupByRaw("DATE_FORMAT(tanggal_pengambilan, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(tanggal_pengambilan, '%Y-%m')")
        ->get();

        return view('Admin.pelaporan', compact('data_laporan'));
    }
}
