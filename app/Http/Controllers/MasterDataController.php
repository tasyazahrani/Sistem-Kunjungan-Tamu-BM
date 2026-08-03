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

    // INSTANSI - AJAX
    public function storeInstansiAjax(Request $request)
    {
        $request->validate([
            'nama_instansi' => ['required', 'string', 'max:150', 'unique:instansis,nama_instansi']
        ]);

        $instansi = Instansi::create([
            'nama_instansi' => $request->nama_instansi,
            'aktif' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Instansi berhasil ditambahkan.',
            'data' => [
                'id' => $instansi->id,
                'nama' => $instansi->nama_instansi,
                'aktif' => $instansi->aktif
            ]
        ]);
    }

    public function updateInstansiAjax(Request $request, Instansi $instansi)
    {
        $request->validate([
            'nama_instansi' => ['required', 'string', 'max:150', 'unique:instansis,nama_instansi,' . $instansi->id]
        ]);

        $instansi->update(['nama_instansi' => $request->nama_instansi]);

        return response()->json([
            'success' => true,
            'message' => 'Instansi berhasil diperbarui.'
        ]);
    }

    public function toggleInstansiAjax(Instansi $instansi)
    {
        $instansi->update(['aktif' => !$instansi->aktif]);

        return response()->json([
            'success' => true,
            'message' => 'Status instansi diperbarui.',
            'aktif' => $instansi->aktif
        ]);
    }

    public function destroyInstansiAjax(Instansi $instansi)
    {
        if ($instansi->kunjungans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Instansi tidak bisa dihapus karena masih digunakan.'
            ], 422);
        }

        $instansi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Instansi berhasil dihapus.'
        ]);
    }

    // TUJUAN - AJAX
    public function storeTujuanAjax(Request $request)
    {
        $request->validate([
            'nama_tujuan' => ['required', 'string', 'max:150', 'unique:tujuan_kunjungans,nama_tujuan']
        ]);

        $tujuan = TujuanKunjungan::create([
            'nama_tujuan' => $request->nama_tujuan,
            'aktif' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tujuan kunjungan berhasil ditambahkan.',
            'data' => [
                'id' => $tujuan->id,
                'nama' => $tujuan->nama_tujuan,
                'aktif' => $tujuan->aktif
            ]
        ]);
    }

    public function updateTujuanAjax(Request $request, TujuanKunjungan $tujuan)
    {
        $request->validate([
            'nama_tujuan' => ['required', 'string', 'max:150', 'unique:tujuan_kunjungans,nama_tujuan,' . $tujuan->id]
        ]);

        $tujuan->update(['nama_tujuan' => $request->nama_tujuan]);

        return response()->json([
            'success' => true,
            'message' => 'Tujuan kunjungan berhasil diperbarui.'
        ]);
    }

    public function toggleTujuanAjax(TujuanKunjungan $tujuan)
    {
        $tujuan->update(['aktif' => !$tujuan->aktif]);

        return response()->json([
            'success' => true,
            'message' => 'Status tujuan kunjungan diperbarui.',
            'aktif' => $tujuan->aktif
        ]);
    }

    public function destroyTujuanAjax(TujuanKunjungan $tujuan)
    {
        if ($tujuan->kunjungans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tujuan tidak bisa dihapus karena masih digunakan.'
            ], 422);
        }

        $tujuan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tujuan kunjungan berhasil dihapus.'
        ]);
    }

    // BIDANG - AJAX
    public function storeBidangAjax(Request $request)
    {
        $request->validate([
            'nama_bidang' => ['required', 'string', 'max:150', 'unique:bidangs,nama_bidang']
        ]);

        $bidang = Bidang::create([
            'nama_bidang' => $request->nama_bidang,
            'aktif' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bidang berhasil ditambahkan.',
            'data' => [
                'id' => $bidang->id,
                'nama' => $bidang->nama_bidang,
                'aktif' => $bidang->aktif
            ]
        ]);
    }

    public function updateBidangAjax(Request $request, Bidang $bidang)
    {
        $request->validate([
            'nama_bidang' => ['required', 'string', 'max:150', 'unique:bidangs,nama_bidang,' . $bidang->id]
        ]);

        $bidang->update(['nama_bidang' => $request->nama_bidang]);

        return response()->json([
            'success' => true,
            'message' => 'Bidang berhasil diperbarui.'
        ]);
    }

    public function toggleBidangAjax(Bidang $bidang)
    {
        $bidang->update(['aktif' => !$bidang->aktif]);

        return response()->json([
            'success' => true,
            'message' => 'Status bidang diperbarui.',
            'aktif' => $bidang->aktif
        ]);
    }

    public function destroyBidangAjax(Bidang $bidang)
    {
        if ($bidang->kunjungans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bidang tidak bisa dihapus karena masih digunakan.'
            ], 422);
        }

        $bidang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bidang berhasil dihapus.'
        ]);
    }
}