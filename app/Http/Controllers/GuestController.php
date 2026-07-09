<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Instansi;
use App\Models\TujuanKunjungan;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function create()
    {
        $instansis = Instansi::where('is_active', true)->get();
        $tujuans = TujuanKunjungan::where('is_active', true)->get();
        $bidangs = Bidang::where('is_active', true)->get();
        
        return view('guest.form', compact('instansis', 'tujuans', 'bidangs'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'jumlah_tamu' => 'required|integer|min:1|max:50',
            'instansi_id' => 'nullable|exists:instansis,id',
            'instansi_lainnya' => 'nullable|string|max:255',
            'tujuan_kunjungan_id' => 'nullable|exists:tujuan_kunjungans,id',
            'tujuan_lainnya' => 'nullable|string|max:255',
            'bidang_id' => 'nullable|exists:bidangs,id',
            'nama_pejabat_dituju' => 'nullable|string|max:255',
            'keperluan' => 'required|string',
        ]);

        // Honeypot anti-spam
        if ($request->filled('website')) {
            return redirect()->back()->with('error', 'Spam detected');
        }

        // Tambahkan data tambahan
        $validated['status'] = 'pending';
        $validated['ip_pengirim'] = $request->ip();
        $validated['waktu_kunjungan'] = now();

        // Jika memilih "Lainnya" untuk instansi
        if ($request->instansi_id === 'lainnya' || $request->filled('instansi_lainnya')) {
            $validated['instansi_id'] = null;
        }

        // Jika memilih "Lainnya" untuk tujuan
        if ($request->tujuan_kunjungan_id === 'lainnya' || $request->filled('tujuan_lainnya')) {
            $validated['tujuan_kunjungan_id'] = null;
        }

        // Simpan data
        $kunjungan = Kunjungan::create($validated);

        return redirect()->route('guest.success', $kunjungan->id)
            ->with('success', 'Data kunjungan berhasil dikirim!');
    }

    public function success($kunjungan)
    {
        $kunjungan = Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->findOrFail($kunjungan);
            
        return view('guest.success', compact('kunjungan'));
    }
}