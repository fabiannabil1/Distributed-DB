<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $pelanggan = Auth::guard('pelanggan')->user();
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            $produkAktif = Produk::where('isActive', 1)
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('nama_produk', 'like', '%' . $keyword . '%');
                })
                ->get();

            $produkNonAktif = Produk::where('isActive', 0)
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('nama_produk', 'like', '%' . $keyword . '%');
                })
                ->get();

            return view('Admin.katalog', compact('produkAktif', 'produkNonAktif', 'keyword'));
        } else {
            $produkListActive = Produk::where('isActive', 1)
                ->where('stok', '>', 0)
                ->when($keyword, function ($query) use ($keyword) {
                    $query->where('nama_produk', 'like', '%' . $keyword . '%');
                })
                ->get();

            return view('Pelanggan.katalog', compact('produkListActive', 'keyword'));
        }
    }

    public function create()
    {
        return view('Layout.Admin.components.katalog-tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ],
        [
            'nama_produk.required' => 'Harap isi nama produk.',
            'deskripsi.required' => 'Harap isi deskripsi produk.',
            'harga.required' => 'Harap masukkan harga produk.',
            'stok.required' => 'Harap masukkan stok produk.',
            'gambar.required' => 'Harap unggah foto produk.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $filename);
            $validated['gambar'] = $filename;
        }

        Produk::create($validated);

        return redirect()->route('katalog.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, Produk $produk)
    {

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->only('nama_produk', 'deskripsi', 'harga', 'stok');

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('storage/images/' . $produk->gambar))) {
                unlink(public_path('storage/images/' . $produk->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $filename);
            $data['gambar'] = $filename;
        }

        $produk->update($data);

        return back()->with('success', 'Produk berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->isActive = 0;
        $produk->save();

        return redirect()->route('katalog.index')->with('success', 'Produk berhasil dinonaktifkan.');
    }

    public function restore($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->isActive = 1;
        $produk->save();

        return redirect()->route('katalog.index')->with('success', 'Produk berhasil dipulihkan.');
    }
}
