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
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') AS bulan, SUM(biaya_berlangganan) AS total_penghasilan")
        ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m') DESC")
        ->get();

        return view('Admin.penghasilanBerlangganan', compact('penghasilan_berlangganan'));
    }
}
