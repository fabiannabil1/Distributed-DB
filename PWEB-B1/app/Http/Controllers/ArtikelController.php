<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ArtikelController extends Controller
{
    public function showArtikelPelanggan()
    {
        $data_artikel = Artikel::with(['admin'])->get();
        return view('Pelanggan.landing', compact('data_artikel'));
    }

    public function showArtikelAdmin()
    {
        $data_artikel = Artikel::with(['admin'])->get();
        return view('Admin.manajemenArtikel', compact('data_artikel'));
    }

    public function create()
    {
        return view('Admin.createArtikel'); 
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar ke folder public/img
        $namaGambar = time() . '_' . Str::random(10) . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('img'), $namaGambar);

        // Simpan ke database
        Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar' => $namaGambar,
            'tanggal_dibuat' => now(), // tanggal otomatis
            'admin_id' => Auth::guard('admin')->id(), // pastikan pakai guard yang sesuai
        ]);

        return redirect()->route('artikel.create')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function read($artikel_id)
    {
        $artikel = Artikel::findOrFail($artikel_id);
        return view('Pelanggan.artikel', compact('artikel'));
    }

    public function edit($artikel_id)
    {
        $artikel = Artikel::findOrFail($artikel_id);
        return view('Admin.updateArtikel', compact('artikel'));
    }

    public function update(Request $request, $artikel_id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        $artikel = Artikel::findOrFail($artikel_id);

        $artikel->judul = $request->judul;
        $artikel->konten = $request->konten;
        $artikel->admin_id =Auth::guard('admin')->id();
        $artikel->tanggal_dibuat = Carbon::now();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('img'), $namaGambar);
            $artikel->gambar = $namaGambar;
        }

        $artikel->save();

        return redirect()->route('artikel.edit', $artikel->artikel_id)->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($artikel_id)
    {
        $artikel = Artikel::findOrFail($artikel_id);
        $artikel->delete();

        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }

}
