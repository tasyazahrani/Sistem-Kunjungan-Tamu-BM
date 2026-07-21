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
    // VARIABLES
    // ============================================
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const editForm = document.getElementById('editForm');
    const editInput = document.getElementById('editInput');
    const editModalTitle = document.getElementById('editModalTitle');
    const editModalLabel = document.getElementById('editModalLabel');
    
    let editType = '';
    let editId = '';

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
    // CREATE (Tambah)
    // ============================================
    document.querySelectorAll('form[data-ajax="true"]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const type = this.dataset.type;
            const input = this.querySelector('input[name="nama_' + type + '"]');
            const name = input.value.trim();
            
            if (!name) return;
            
            showLoading(true);
            
            try {
                const response = await fetchAjax(getRoute(type, 'store'), {
                    method: 'POST',
                    body: JSON.stringify({ ['nama_' + type]: name })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const list = getList(type);
                    const newItem = createListItem(type, data.data);
                    list.insertBefore(newItem, list.firstChild);
                    input.value = '';
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Gagal menambahkan data.', 'error');
                }
            } catch (error) {
                showToast('Terjadi kesalahan pada server.', 'error');
            }
            
            showLoading(false);
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
        
        // Edit button
        const editBtn = document.createElement('button');
        editBtn.className = 'btn btn-sm btn-outline-primary edit-btn';
        editBtn.dataset.type = type;
        editBtn.dataset.id = data.id;
        editBtn.dataset.name = data.nama;
        editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
        
        // Toggle button
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'btn btn-sm btn-outline-secondary toggle-btn';
        toggleBtn.dataset.type = type;
        toggleBtn.dataset.id = data.id;
        toggleBtn.textContent = data.aktif ? 'Nonaktifkan' : 'Aktifkan';
        
        // Delete button
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
        
        // Attach events
        editBtn.addEventListener('click', openEditModal);
        toggleBtn.addEventListener('click', handleToggle);
        deleteBtn.addEventListener('click', handleDelete);
        
        return li;
    }

    // ============================================
    // EDIT - Open Modal
    // ============================================
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', openEditModal);
    });

    function openEditModal(e) {
        const btn = e.currentTarget;
        editType = btn.dataset.type;
        editId = btn.dataset.id;
        const name = btn.dataset.name;
        
        const labels = {
            'instansi': 'Nama Instansi',
            'tujuan': 'Nama Tujuan',
            'bidang': 'Nama Bidang'
        };
        
        editModalTitle.textContent = 'Edit ' + (labels[editType] || '');
        editModalLabel.textContent = labels[editType] || 'Nama';
        editInput.value = name;
        editForm.action = getRoute(editType, 'update', editId);
        editModal.show();
    }

    // ============================================
    // EDIT - Submit
    // ============================================
    editForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = editInput.value.trim();
        if (!name) return;
        
        showLoading(true);
        
        try {
            const response = await fetchAjax(this.action, {
                method: 'POST',
                body: JSON.stringify({ 
                    _method: 'PUT',
                    ['nama_' + editType]: name 
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                const list = getList(editType);
                const items = list.querySelectorAll('li');
                items.forEach(item => {
                    if (item.dataset.id == editId) {
                        const span = item.querySelector('span');
                        span.textContent = name;
                    }
                });
                editModal.hide();
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal mengupdate data.', 'error');
            }
        } catch (error) {
            showToast('Terjadi kesalahan pada server.', 'error');
        }
        
        showLoading(false);
    });

    // ============================================
    // TOGGLE (Aktif/Nonaktif)
    // ============================================
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', handleToggle);
    });

    async function handleToggle(e) {
        const btn = e.currentTarget;
        const type = btn.dataset.type;
        const id = btn.dataset.id;
        
        showLoading(true);
        
        try {
            const response = await fetchAjax(getRoute(type, 'toggle', id), {
                method: 'POST',
                body: JSON.stringify({ _method: 'PATCH' })
            });
            
            const data = await response.json();
            
            if (data.success) {
                const list = getList(type);
                const items = list.querySelectorAll('li');
                items.forEach(item => {
                    if (item.dataset.id == id) {
                        const span = item.querySelector('span');
                        const toggleBtn = item.querySelector('.toggle-btn');
                        if (data.aktif) {
                            span.classList.remove('text-muted', 'text-decoration-line-through');
                            toggleBtn.textContent = 'Nonaktifkan';
                        } else {
                            span.classList.add('text-muted', 'text-decoration-line-through');
                            toggleBtn.textContent = 'Aktifkan';
                        }
                    }
                });
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal mengubah status.', 'error');
            }
        } catch (error) {
            showToast('Terjadi kesalahan pada server.', 'error');
        }
        
        showLoading(false);
    }

    // ============================================
    // DELETE
    // ============================================
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', handleDelete);
    });

    async function handleDelete(e) {
        const btn = e.currentTarget;
        const type = btn.dataset.type;
        const id = btn.dataset.id;
        
        if (!confirm('Yakin ingin menghapus data ini?')) return;
        
        showLoading(true);
        
        try {
            const response = await fetchAjax(getRoute(type, 'delete', id), {
                method: 'POST',
                body: JSON.stringify({ _method: 'DELETE' })
            });
            
            const data = await response.json();
            
            if (data.success) {
                const list = getList(type);
                const items = list.querySelectorAll('li');
                items.forEach(item => {
                    if (item.dataset.id == id) {
                        item.remove();
                    }
                });
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Gagal menghapus data.', 'error');
            }
        } catch (error) {
            showToast('Terjadi kesalahan pada server.', 'error');
        }
        
        showLoading(false);
    }

    // ============================================
    // MODAL - Reset saat ditutup
    // ============================================
    document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
        editForm.action = '';
        editInput.value = '';
        editType = '';
        editId = '';
    });
});
</script>
@endpush