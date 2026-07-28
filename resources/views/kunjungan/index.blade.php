@extends('layouts.app')

@section('title', 'Verifikasi Kunjungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Verifikasi & Kelola Kunjungan</h4>
        <a href="{{ route('kunjungan.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Input Manual
        </a>
    </div>

    {{-- Filter --}}
    <div class="card card-stat p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ $filters['tanggal_mulai'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="tanggal_akhir" class="form-control form-control-sm" value="{{ $filters['tanggal_akhir'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Instansi</label>
                <select name="instansi_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($instansis as $i)
                        <option value="{{ $i->id }}" {{ ($filters['instansi_id'] ?? '') == $i->id ? 'selected' : '' }}>{{ $i->nama_instansi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Tujuan</label>
                <select name="tujuan_kunjungan_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($tujuans as $t)
                        <option value="{{ $t->id }}" {{ ($filters['tujuan_kunjungan_id'] ?? '') == $t->id ? 'selected' : '' }}>{{ $t->nama_tujuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Cari Nama/Kode/HP</label>
                <input type="text" name="cari" class="form-control form-control-sm" value="{{ $filters['cari'] ?? '' }}">
            </div>
            <div class="col-12 mt-2">
                <button class="btn btn-sm btn-success"><i class="bi bi-search"></i> Terapkan Filter</button>
                <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card card-stat p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                <tr>
                    <th>Kode</th><th>Waktu</th><th>Nama Tamu</th><th>Instansi</th><th>Tujuan</th><th>Status</th><th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($kunjungans as $k)
                    <tr data-id="{{ $k->id }}">
                        <td class="small">{{ $k->kode_kunjungan }}</td>
                        <td class="small">{{ $k->waktu_kunjungan->format('d-m-Y H:i') }}</td>
                        <td>{{ $k->nama_tamu }} @if($k->input_manual)<span class="badge bg-secondary">manual</span>@endif</td>
                        <td class="small">{{ $k->nama_instansi }}</td>
                        <td class="small">{{ $k->nama_tujuan }}</td>
                        <td><span class="badge bg-{{ $k->status_color }} badge-status" id="statusBadge-{{ $k->id }}">{{ $k->status_label }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-success verif-btn" data-id="{{ $k->id }}" data-name="{{ $k->nama_tamu }}" data-kode="{{ $k->kode_kunjungan }}" data-keperluan="{{ $k->keperluan }}" data-status="{{ $k->status }}" data-catatan="{{ $k->catatan_petugas }}" title="Verifikasi">
                                    <i class="bi bi-check2-square"></i>
                                </button>
                                <a href="{{ route('kunjungan.edit', $k) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kunjungan.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus data kunjungan ini?')" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data kunjungan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </div>

    {{-- Modal Verifikasi (Satu Modal untuk Semua) --}}
    <div class="modal fade" id="verifModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="verifForm" class="modal-content">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h6 class="modal-title" id="verifModalTitle">Verifikasi Kunjungan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted" id="verifModalInfo">
                        Kode: -<br>
                        Keperluan: -
                    </p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" id="verifStatus" class="form-select" required>
                            @foreach($statusList as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Catatan Petugas (opsional)</label>
                        <textarea name="catatan_petugas" id="verifCatatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success" id="verifSubmitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // CSRF TOKEN
    // ============================================
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // ============================================
    // TOAST NOTIFICATION
    // ============================================
    function showToast(message, type = 'success') {
        if (window.showToast) {
            window.showToast(message, type);
        } else {
            alert(message);
        }
    }

    // ============================================
    // OPEN VERIFY MODAL
    // ============================================
    document.querySelectorAll('.verif-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const kode = this.dataset.kode;
            const keperluan = this.dataset.keperluan;
            const status = this.dataset.status;
            const catatan = this.dataset.catatan || '';

            document.getElementById('verifModalTitle').textContent = 'Verifikasi: ' + name;
            document.getElementById('verifModalInfo').innerHTML = 
                'Kode: ' + kode + '<br>Keperluan: ' + keperluan;

            document.getElementById('verifStatus').value = status;
            document.getElementById('verifCatatan').value = catatan;
            document.getElementById('verifForm').action = '/kunjungan/' + id + '/verifikasi';
            document.getElementById('verifForm').dataset.id = id;

            const modal = new bootstrap.Modal(document.getElementById('verifModal'));
            modal.show();
        });
    });

    // ============================================
    // VERIFY FORM - AJAX SUBMIT
    // ============================================
    document.getElementById('verifForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const id = this.dataset.id;
        const status = document.getElementById('verifStatus').value;
        const catatan = document.getElementById('verifCatatan').value;

        const submitBtn = document.getElementById('verifSubmitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Menyimpan...';
        submitBtn.disabled = true;

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PATCH',
                status: status,
                catatan_petugas: catatan
            })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;

            if (data.success) {
                // Update status badge
                const badge = document.querySelector('#statusBadge-' + id);
                if (badge) {
                    badge.textContent = data.status_label;
                    badge.className = 'badge bg-' + data.status_color + ' badge-status';
                }

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('verifModal'));
                if (modal) modal.hide();

                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal memverifikasi!', 'error');
            }
        })
        .catch(error => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            showToast('Terjadi kesalahan pada server.', 'error');
            console.error('Error:', error);
        });
    });

    // ============================================
    // DELETE - AJAX (Opsional)
    // ============================================
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!confirm('Hapus data kunjungan ini?')) return;

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            submitBtn.disabled = true;

            fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;

                if (data.success) {
                    const row = this.closest('tr');
                    if (row) row.remove();
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Gagal menghapus!', 'error');
                }
            })
            .catch(() => {
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;
                showToast('Terjadi kesalahan!', 'error');
            });
        });
    });
});
</script>
@endpush