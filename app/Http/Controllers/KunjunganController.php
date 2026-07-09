<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\Kunjungan;
use App\Models\TujuanKunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    /**
     * Daftar kunjungan yang menunggu / sedang diproses (untuk petugas & admin).
     */
    public function index(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'instansi_id', 'tujuan_kunjungan_id', 'status', 'cari']);

        $kunjungans = Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->filter($filters)
            ->latest('waktu_kunjungan')
            ->paginate(15)
            ->withQueryString();

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::orderBy('nama_tujuan')->get();
        $statusList = Kunjungan::STATUS_LABELS;

        return view('kunjungan.index', compact('kunjungans', 'instansis', 'tujuans', 'statusList', 'filters'));
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['instansi', 'tujuanKunjungan', 'bidang', 'petugasVerifikasi', 'petugasInput']);

        return view('kunjungan.show', compact('kunjungan'));
    }

    /**
     * Form input manual oleh petugas (tamu kesulitan mengisi sendiri).
     */
    public function create()
    {
        $instansis = Instansi::where('aktif', true)->orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::where('aktif', true)->orderBy('nama_tujuan')->get();
        $bidangs = Bidang::where('aktif', true)->orderBy('nama_bidang')->get();

        return view('kunjungan.create', compact('instansis', 'tujuans', 'bidangs'));
    }

    public function store(Request $request)
    {
        $validated = $this->validasiKunjungan($request);

        Kunjungan::create(array_merge($validated, [
            'status' => $request->input('status', 'disetujui'),
            'input_manual' => true,
            'diinput_oleh' => auth()->id(),
            'diverifikasi_oleh' => auth()->id(),
            'waktu_verifikasi' => now(),
            'waktu_kunjungan' => now(),
            'ip_pengirim' => $request->ip(),
        ]));

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil diinput.');
    }

    public function edit(Kunjungan $kunjungan)
    {
        $instansis = Instansi::orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::orderBy('nama_tujuan')->get();
        $bidangs = Bidang::orderBy('nama_bidang')->get();

        return view('kunjungan.edit', compact('kunjungan', 'instansis', 'tujuans', 'bidangs'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $validated = $this->validasiKunjungan($request);
        $kunjungan->update($validated);

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    /**
     * Ubah status verifikasi kunjungan.
     */
    public function verifikasi(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status' => ['required', 'in:menunggu_verifikasi,disetujui,sedang_berkunjung,selesai,ditolak'],
            'catatan_petugas' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'status' => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
            'diverifikasi_oleh' => auth()->id(),
            'waktu_verifikasi' => $kunjungan->waktu_verifikasi ?? now(),
        ];

        if ($request->status === 'selesai') {
            $data['waktu_selesai'] = now();
        }

        $kunjungan->update($data);

        return back()->with('success', 'Status kunjungan berhasil diperbarui menjadi "' . Kunjungan::STATUS_LABELS[$request->status] . '".');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();

        return back()->with('success', 'Data kunjungan berhasil dihapus.');
    }

    private function validasiKunjungan(Request $request): array
    {
        return $request->validate([
            'nama_tamu' => ['required', 'string', 'max:150'],
            'no_hp' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'instansi_id' => ['nullable', 'exists:instansis,id'],
            'instansi_lainnya' => ['nullable', 'string', 'max:150'],
            'alamat_instansi' => ['nullable', 'string', 'max:255'],
            'jumlah_tamu' => ['required', 'integer', 'min:1', 'max:50'],
            'tujuan_kunjungan_id' => ['nullable', 'exists:tujuan_kunjungans,id'],
            'tujuan_lainnya' => ['nullable', 'string', 'max:150'],
            'bidang_id' => ['nullable', 'exists:bidangs,id'],
            'nama_pejabat_dituju' => ['nullable', 'string', 'max:150'],
            'keperluan' => ['required', 'string', 'max:1000'],
            'status' => ['sometimes', 'in:menunggu_verifikasi,disetujui,sedang_berkunjung,selesai,ditolak'],
        ]);
    }
}
