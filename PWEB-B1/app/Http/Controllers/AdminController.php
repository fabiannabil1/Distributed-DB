<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function updateProfileAndPassword(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|digits_between:11,15',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min' => 'Minimal karakter password 8',
            'nomor_telepon.digits_between' => 'Nomor telepon kurang dari 11 digit',
        ]);

        $admin = auth('admin')->user();
        $admin->nama_lengkap = $request->nama_lengkap;
        $admin->nomor_telepon = $request->nomor_telepon;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        if ($request->ajax()) {
            return response()->json(['success' => true], 200);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
