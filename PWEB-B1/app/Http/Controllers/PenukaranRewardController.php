<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Reward;
use App\Models\PengambilanSampah;
use App\Models\DetailReward;


use Illuminate\Http\Request;

class PenukaranRewardController extends Controller
{
    public function showReward()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $totalEmber = $pelanggan->pengambilanSampah->jumlah_ember ?? 0;
        $reward=Reward::all();

        return view('Pelanggan.reward', compact('pelanggan', 'totalEmber', 'reward'));
    }

    public function tukar($reward_id)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $reward = Reward::findOrFail($reward_id);

        // Ambil data pengambilan sampah berdasarkan pelanggan login
        $pengambilan = PengambilanSampah::where('pelanggan_id', $pelanggan->pelanggan_id)->first();

        if (!$pengambilan) {
            return back()->with('error', 'Data pengambilan ember tidak ditemukan.');
        }

        // Cek apakah ember mencukupi
        if ($pengambilan->jumlah_ember < $reward->jumlah_ember_harga) {
            return back()->with('error', 'Ember Anda tidak cukup untuk menukar reward ini.');
        }

        // Kurangi jumlah ember
        $pengambilan->jumlah_ember -= $reward->jumlah_ember_harga;
        $pengambilan->save();

        // Simpan ke tabel detail_reward
        DetailReward::create([
            'pelanggan_id' => $pelanggan->pelanggan_id,
            'reward_id' => $reward->reward_id,
            'status_reward_id' => 1
        ]);

        return back()->with('success', 'Reward berhasil ditukar!');
    }

    public function riwayatReward()
    {
        // Ambil pelanggan yang sedang login
        $pelanggan = Auth::guard('pelanggan')->user();

        // Ambil data riwayat reward sesuai pelanggan login
        $riwayatreward = DetailReward::with(['reward','statusReward'])
                            ->where('pelanggan_id', $pelanggan->pelanggan_id)
                            ->latest()
                            ->get();

        return view('Pelanggan.riwayatReward', compact('riwayatreward'));
    }
}
