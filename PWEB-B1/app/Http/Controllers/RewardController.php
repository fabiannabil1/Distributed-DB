<?php

namespace App\Http\Controllers;

use App\Models\DetailReward;
use App\Models\Reward;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function showRewardAdmin()
    {
        $data_reward = Reward::all();
        return view('Admin.manajemenReward', compact('data_reward'));
    }

    public function create()
    {
        return view('Admin.createReward');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_ember_harga' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar ke folder public/img
        $namaGambar = time() . '_' . Str::random(10) . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('img'), $namaGambar);

        // Simpan ke database
        Reward::create([
            'nama' => $request->nama,
            'jumlah_ember_harga' => $request->jumlah_ember_harga,
            'gambar' => $namaGambar,
        ]);

        return redirect()->route('reward.create')->with('success', 'Reward berhasil ditambahkan!');
    }

    public function edit($reward_id)
    {
        $reward = Reward::findOrFail($reward_id);
        return view('Admin.updateReward', compact('reward'));
    }

    public function update(Request $request, $reward_id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_ember_harga' => 'required|integer',
            'gambar' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        $reward = Reward::findOrFail($reward_id);

        $reward->nama = $request->nama;
        $reward->jumlah_ember_harga = $request->jumlah_ember_harga;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('img'), $namaGambar);
            $reward->gambar = $namaGambar;
        }

        $reward->save();

        return redirect()->route('reward.edit', $reward->reward_id)->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy($reward_id)
    {
        $reward = Reward::findOrFail($reward_id);
        $reward->delete();

        return redirect()->back()->with('success', 'Reward berhasil dihapus.');
    }

    public function konfirmasiReward()
    {
        $reward = DetailReward::with(['pelanggan', 'reward', 'statusReward'])
                ->whereIn('status_reward_id', [1, 2])
                ->get();
        return view('Admin.konfirmasiReward', compact('reward'));
    }

    public function ubahStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:detail_rewards,detail_reward_id',
            'status' => 'required|integer|exists:status_rewards,status_reward_id',
        ]);

        try {
            $reward = DetailReward::findOrFail($request->id);
            $reward->status_reward_id = $request->status;
            $reward->save();

            // Jika permintaan AJAX, kirimkan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            // Jika bukan AJAX, redirect biasa
            return redirect()->back()->with('success', 'Status reward berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui status reward.');
        }
    }


}
