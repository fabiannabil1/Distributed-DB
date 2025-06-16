<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ManajemenPelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::paginate(10);
        return view('admin.manajemenPelanggan', compact('pelanggans'));
    }


    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.manajemen-pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status_berlangganan' => 'required|string|max:100',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        if ($request->status_berlangganan == "Tidak Aktif" && $pelanggan->status_berlangganan == "Aktif") {
            $pelanggan->tanggal_berlangganan = now();
        }

        $pelanggan->latitude = $request->latitude;
        $pelanggan->longitude = $request->longitude;
        $pelanggan->status_berlangganan = $request->status_berlangganan;
        $pelanggan->save();

        return response()->json(['success' => true]);
    }


}
