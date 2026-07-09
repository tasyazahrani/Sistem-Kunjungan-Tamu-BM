<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\TujuanKunjungan;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $instansis = Instansi::orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::orderBy('nama_tujuan')->get();
        $bidangs = Bidang::orderBy('nama_bidang')->get();

        return view('master.index', compact('instansis', 'tujuans', 'bidangs'));
    }

    // ---------- Instansi ----------
    public function storeInstansi(Request $request)
    {
        $request->validate(['nama_instansi' => ['required', 'string', 'max:150', 'unique:instansis,nama_instansi']]);
        Instansi::create(['nama_instansi' => $request->nama_instansi]);

        return back()->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function toggleInstansi(Instansi $instansi)
    {
        $instansi->update(['aktif' => ! $instansi->aktif]);

        return back()->with('success', 'Status instansi diperbarui.');
    }

    public function destroyInstansi(Instansi $instansi)
    {
        $instansi->delete();

        return back()->with('success', 'Instansi dihapus.');
    }

    // ---------- Tujuan Kunjungan ----------
    public function storeTujuan(Request $request)
    {
        $request->validate(['nama_tujuan' => ['required', 'string', 'max:150', 'unique:tujuan_kunjungans,nama_tujuan']]);
        TujuanKunjungan::create(['nama_tujuan' => $request->nama_tujuan]);

        return back()->with('success', 'Tujuan kunjungan berhasil ditambahkan.');
    }

    public function toggleTujuan(TujuanKunjungan $tujuan)
    {
        $tujuan->update(['aktif' => ! $tujuan->aktif]);

        return back()->with('success', 'Status tujuan kunjungan diperbarui.');
    }

    public function destroyTujuan(TujuanKunjungan $tujuan)
    {
        $tujuan->delete();

        return back()->with('success', 'Tujuan kunjungan dihapus.');
    }

    // ---------- Bidang ----------
    public function storeBidang(Request $request)
    {
        $request->validate(['nama_bidang' => ['required', 'string', 'max:150', 'unique:bidangs,nama_bidang']]);
        Bidang::create(['nama_bidang' => $request->nama_bidang]);

        return back()->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function toggleBidang(Bidang $bidang)
    {
        $bidang->update(['aktif' => ! $bidang->aktif]);

        return back()->with('success', 'Status bidang diperbarui.');
    }

    public function destroyBidang(Bidang $bidang)
    {
        $bidang->delete();

        return back()->with('success', 'Bidang dihapus.');
    }
}
