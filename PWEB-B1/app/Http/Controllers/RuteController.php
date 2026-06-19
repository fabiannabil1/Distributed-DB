<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class RuteController extends Controller
{
    public function showRute()
    {
        $datarute = Pelanggan::with(['tempatSampah', 'pengambilanSampah'])->get();
        return view('Admin.rute', compact('datarute'));
    }
}
