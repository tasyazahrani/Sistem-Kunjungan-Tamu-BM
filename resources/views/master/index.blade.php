@extends('layouts.app')

@section('title', 'Data Master')

@section('content')
    <h4 class="fw-bold mb-4">Kelola Data Master</h4>

    <div class="row g-3">
        {{-- ============================================ --}}
        {{-- INSTANSI                                     --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Instansi</div>
                
                {{-- Form Tambah --}}
                <form class="d-flex gap-2 mb-3" data-ajax="true" data-type="instansi">
                    @csrf
                    <input type="text" name="nama_instansi" class="form-control form-control-sm" placeholder="Nama instansi baru" required>
                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                
                {{-- List --}}
                <ul class="list-group list-group-flush" id="instansiList" style="max-height: 400px; overflow-y: auto;">
                    @foreach($instansis as $i)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" data-id="{{ $i->id }}">
                            <span class="small {{ !$i->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $i->nama_instansi }}</span>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary edit-btn" data-type="instansi" data-id="{{ $i->id }}" data-name="{{ $i->nama_instansi }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary toggle-btn" data-type="instansi" data-id="{{ $i->id }}">
                                    {{ $i->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-type="instansi" data-id="{{ $i->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- TUJUAN                                       --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Tujuan Kunjungan</div>
                
                {{-- Form Tambah --}}
                <form class="d-flex gap-2 mb-3" data-ajax="true" data-type="tujuan">
                    @csrf
                    <input type="text" name="nama_tujuan" class="form-control form-control-sm" placeholder="Tujuan baru" required>
                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                
                {{-- List --}}
                <ul class="list-group list-group-flush" id="tujuanList" style="max-height: 400px; overflow-y: auto;">
                    @foreach($tujuans as $t)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" data-id="{{ $t->id }}">
                            <span class="small {{ !$t->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $t->nama_tujuan }}</span>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary edit-btn" data-type="tujuan" data-id="{{ $t->id }}" data-name="{{ $t->nama_tujuan }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary toggle-btn" data-type="tujuan" data-id="{{ $t->id }}">
                                    {{ $t->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-type="tujuan" data-id="{{ $t->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- BIDANG                                       --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Bidang / Bagian</div>
                
                {{-- Form Tambah --}}
                <form class="d-flex gap-2 mb-3" data-ajax="true" data-type="bidang">
                    @csrf
                    <input type="text" name="nama_bidang" class="form-control form-control-sm" placeholder="Bidang baru" required>
                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                
                {{-- List --}}
                <ul class="list-group list-group-flush" id="bidangList" style="max-height: 400px; overflow-y: auto;">
                    @foreach($bidangs as $b)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" data-id="{{ $b->id }}">
                            <span class="small {{ !$b->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $b->nama_bidang }}</span>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary edit-btn" data-type="bidang" data-id="{{ $b->id }}" data-name="{{ $b->nama_bidang }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary toggle-btn" data-type="bidang" data-id="{{ $b->id }}">
                                    {{ $b->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-type="bidang" data-id="{{ $b->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- MODAL EDIT                                   --}}
    {{-- ============================================ --}}
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold" id="editModalTitle">Edit</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-0">
                            <label class="form-label small fw-semibold" id="editModalLabel">Nama</label>
                            <input type="text" name="nama" class="form-control form-control-sm" id="editInput" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
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
    // TOAST & LOADING
    // ============================================
    function showToast(message, type = 'success') {
        if (window.showToast) {
            window.showToast(message, type);
        } else {
            alert(message);
        }
    }

    function showLoading(show) {
        if (window.showLoading) {
            window.showLoading(show);
        }
    }

    // ============================================
    // HELPER: Get List Element
    // ============================================
    function getList(type) {
        const map = {
            'instansi': 'instansiList',
            'tujuan': 'tujuanList',
            'bidang': 'bidangList'
        };
        return document.getElementById(map[type]);
    }

    // ============================================
    // HELPER: Get Route
    // ============================================
    function getRoute(type, action, id = null) {
        const routes = {
            'instansi': {
                store: '/master-data/instansi',
                update: `/master-data/instansi/${id}`,
                toggle: `/master-data/instansi/${id}/toggle-ajax`,
                delete: `/master-data/instansi/${id}/delete-ajax`
            },
            'tujuan': {
                store: '/master-data/tujuan',
                update: `/master-data/tujuan/${id}`,
                toggle: `/master-data/tujuan/${id}/toggle-ajax`,
                delete: `/master-data/tujuan/${id}/delete-ajax`
            },
            'bidang': {
                store: '/master-data/bidang',
                update: `/master-data/bidang/${id}`,
                toggle: `/master-data/bidang/${id}/toggle-ajax`,
                delete: `/master-data/bidang/${id}/delete-ajax`
            }
        };
        return routes[type]?.[action] || '';
    }

    // ============================================
    // EVENT DELEGATION - Toggle
    // ============================================
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.toggle-btn');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const type = btn.dataset.type;
        const id = btn.dataset.id;
        const li = btn.closest('li');
        const span = li.querySelector('span');
        
        const originalText = btn.textContent;
        btn.textContent = '...';
        btn.disabled = true;
        
        showLoading(true);
        
        fetch(getRoute(type, 'toggle', id), {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.textContent = originalText;
            btn.disabled = false;
            showLoading(false);
            
            if (data.success) {
                if (data.aktif) {
                    span.classList.remove('text-muted', 'text-decoration-line-through');
                    btn.textContent = 'Nonaktifkan';
                } else {
                    span.classList.add('text-muted', 'text-decoration-line-through');
                    btn.textContent = 'Aktifkan';
                }
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal mengubah status.', 'error');
            }
        })
        .catch(error => {
            btn.textContent = originalText;
            btn.disabled = false;
            showLoading(false);
            showToast('Terjadi kesalahan pada server.', 'error');
            console.error('Error:', error);
        });
    });

    // ============================================
    // EVENT DELEGATION - Delete
    // ============================================
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const type = btn.dataset.type;
        const id = btn.dataset.id;
        const li = btn.closest('li');
        
        if (!confirm('Yakin ingin menghapus data ini?')) return;
        
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        btn.disabled = true;
        
        showLoading(true);
        
        fetch(getRoute(type, 'delete', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            showLoading(false);
            
            if (data.success) {
                li.remove();
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal menghapus data.', 'error');
            }
        })
        .catch(error => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            showLoading(false);
            showToast('Terjadi kesalahan pada server.', 'error');
            console.error('Error:', error);
        });
    });

    // ============================================
    // EVENT DELEGATION - Edit (Open Modal)
    // ============================================
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (!btn) return;
        
        e.preventDefault();
        
        const type = btn.dataset.type;
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        
        const labels = {
            'instansi': 'Nama Instansi',
            'tujuan': 'Nama Tujuan',
            'bidang': 'Nama Bidang'
        };
        
        document.getElementById('editModalTitle').textContent = 'Edit ' + (labels[type] || '');
        document.getElementById('editModalLabel').textContent = labels[type] || 'Nama';
        document.getElementById('editInput').value = name;
        document.getElementById('editForm').action = getRoute(type, 'update', id);
        document.getElementById('editForm').dataset.type = type;
        document.getElementById('editForm').dataset.id = id;
        
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });

    // ============================================
    // EDIT - Submit
    // ============================================
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const type = this.dataset.type;
        const id = this.dataset.id;
        const name = document.getElementById('editInput').value.trim();
        
        if (!name) return;
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Menyimpan...';
        submitBtn.disabled = true;
        
        showLoading(true);
        
        fetch(getRoute(type, 'update', id), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                _method: 'PUT',
                ['nama_' + type]: name 
            })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            showLoading(false);
            
            if (data.success) {
                const list = getList(type);
                const items = list.querySelectorAll('li');
                items.forEach(item => {
                    if (item.dataset.id == id) {
                        const span = item.querySelector('span');
                        span.textContent = name;
                        // Update juga data-name di edit-btn
                        const editBtn = item.querySelector('.edit-btn');
                        if (editBtn) editBtn.dataset.name = name;
                    }
                });
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                if (modal) modal.hide();
                
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal mengupdate data.', 'error');
            }
        })
        .catch(error => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            showLoading(false);
            showToast('Terjadi kesalahan pada server.', 'error');
            console.error('Error:', error);
        });
    });

    // ============================================
    // CREATE (Tambah) - AJAX
    // ============================================
    document.querySelectorAll('form[data-ajax="true"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const type = this.dataset.type;
            const input = this.querySelector('input[name="nama_' + type + '"]');
            const name = input.value.trim();
            
            if (!name) return;
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            submitBtn.disabled = true;
            
            showLoading(true);
            
            fetch(getRoute(type, 'store'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ['nama_' + type]: name })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;
                showLoading(false);
                
                if (data.success) {
                    const list = getList(type);
                    const newItem = createListItem(type, data.data);
                    list.insertBefore(newItem, list.firstChild);
                    input.value = '';
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Gagal menambahkan data.', 'error');
                }
            })
            .catch(error => {
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;
                showLoading(false);
                showToast('Terjadi kesalahan pada server.', 'error');
                console.error('Error:', error);
            });
        });
    });

    // ============================================
    // CREATE LIST ITEM
    // ============================================
    function createListItem(type, data) {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center px-0 py-2';
        li.dataset.id = data.id;
        
        const nameSpan = document.createElement('span');
        nameSpan.className = 'small';
        nameSpan.textContent = data.nama;
        
        const div = document.createElement('div');
        div.className = 'd-flex gap-1';
        
        // Edit button - TIDAK PERLU attach event lagi karena event delegation
        const editBtn = document.createElement('button');
        editBtn.className = 'btn btn-sm btn-outline-primary edit-btn';
        editBtn.dataset.type = type;
        editBtn.dataset.id = data.id;
        editBtn.dataset.name = data.nama;
        editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
        
        // Toggle button - TIDAK PERLU attach event lagi karena event delegation
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'btn btn-sm btn-outline-secondary toggle-btn';
        toggleBtn.dataset.type = type;
        toggleBtn.dataset.id = data.id;
        toggleBtn.textContent = data.aktif ? 'Nonaktifkan' : 'Aktifkan';
        
        // Delete button - TIDAK PERLU attach event lagi karena event delegation
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'btn btn-sm btn-outline-danger delete-btn';
        deleteBtn.dataset.type = type;
        deleteBtn.dataset.id = data.id;
        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
        
        div.appendChild(editBtn);
        div.appendChild(toggleBtn);
        div.appendChild(deleteBtn);
        
        li.appendChild(nameSpan);
        li.appendChild(div);
        
        return li;
    }

    // ============================================
    // MODAL - Reset saat ditutup
    // ============================================
    document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('editForm').action = '';
        document.getElementById('editForm').dataset.type = '';
        document.getElementById('editForm').dataset.id = '';
        document.getElementById('editInput').value = '';
    });
});
</script>
@endpush