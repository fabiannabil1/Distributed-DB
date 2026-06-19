<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PenghasilanBerlanggananController extends Controller
{
    public function penghasilanBerlangganan()
    {
        $penghasilan_berlangganan = DB::table('berlangganans')
        ->selectRaw("TO_CHAR(created_at, 'YYYY-MM') AS bulan, SUM(biaya_berlangganan) AS total_penghasilan")
        ->groupByRaw("TO_CHAR(created_at, 'YYYY-MM')")
        ->orderByRaw("TO_CHAR(created_at, 'YYYY-MM') DESC")
        ->get();

        return view('Admin.penghasilanBerlangganan', compact('penghasilan_berlangganan'));
    }
}
