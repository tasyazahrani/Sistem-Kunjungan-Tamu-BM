@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="nama_tamu" class="form-control" value="{{ old('nama_tamu', $kunjungan->nama_tamu ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">No. HP <span class="text-danger">*</span></label>
        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $kunjungan->no_hp ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $kunjungan->email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Jumlah Tamu <span class="text-danger">*</span></label>
        <input type="number" min="1" max="50" name="jumlah_tamu" class="form-control" value="{{ old('jumlah_tamu', $kunjungan->jumlah_tamu ?? 1) }}" required>
    </div>

    {{-- ================= KOLOM PEKERJAAN (BARU) ================= --}}
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Pekerjaan / Profesi</label>
        <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $kunjungan->pekerjaan ?? '') }}" placeholder="Contoh: PNS, Swasta, Wiraswasta">
    </div>

    {{-- ================= KOLOM JABATAN (BARU) ================= --}}
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Jabatan / Unit Kerja</label>
        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $kunjungan->jabatan ?? '') }}" placeholder="Contoh: Kepala Dinas, Kabid, Staff">
    </div>
    {{-- ========================================================= --}}

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Instansi</label>
        <select name="instansi_id" class="form-select">
            <option value="">-- Pilih Instansi --</option>
            @foreach($instansis as $i)
                <option value="{{ $i->id }}" {{ old('instansi_id', $kunjungan->instansi_id ?? '') == $i->id ? 'selected' : '' }}>{{ $i->nama_instansi }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Instansi Lainnya</label>
        <input type="text" name="instansi_lainnya" class="form-control" value="{{ old('instansi_lainnya', $kunjungan->instansi_lainnya ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tujuan Kunjungan</label>
        <select name="tujuan_kunjungan_id" class="form-select">
            <option value="">-- Pilih Tujuan --</option>
            @foreach($tujuans as $t)
                <option value="{{ $t->id }}" {{ old('tujuan_kunjungan_id', $kunjungan->tujuan_kunjungan_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->nama_tujuan }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tujuan Lainnya</label>
        <input type="text" name="tujuan_lainnya" class="form-control" value="{{ old('tujuan_lainnya', $kunjungan->tujuan_lainnya ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Bidang yang Dituju</label>
        <select name="bidang_id" class="form-select">
            <option value="">-- Pilih Bidang --</option>
            @foreach($bidangs as $b)
                <option value="{{ $b->id }}" {{ old('bidang_id', $kunjungan->bidang_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->nama_bidang }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama Pejabat yang Dituju</label>
        <input type="text" name="nama_pejabat_dituju" class="form-control" value="{{ old('nama_pejabat_dituju', $kunjungan->nama_pejabat_dituju ?? '') }}">
    </div>

    <div class="col-12">
        <label class="form-label small fw-semibold">Keperluan <span class="text-danger">*</span></label>
        <textarea name="keperluan" rows="3" class="form-control" required>{{ old('keperluan', $kunjungan->keperluan ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Status</label>
        <select name="status" class="form-select">
            @foreach(\App\Models\Kunjungan::STATUS_LABELS as $key => $label)
                <option value="{{ $key }}" {{ old('status', $kunjungan->status ?? 'disetujui') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<button type="submit" class="btn btn-success mt-4">
    <i class="bi bi-save"></i> Simpan Data
</button>
<a href="{{ route('kunjungan.index') }}" class="btn btn-outline-secondary mt-4">Batal</a>