<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Kelola Role</h1>
                <p class="text-muted mb-0">Mengelola role dan permission sistem</p>
            </div>
            <div>
                <a href="/admin/roles/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Role
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= count($roles) ?></div>
                    <div class="stats-label">Total Role</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-tag fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= array_sum(array_column($roles, 'user_count')) ?></div>
                    <div class="stats-label">Total Pengguna</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= count(array_filter($roles, fn($role) => $role['name'] == 'super_admin')) ?></div>
                    <div class="stats-label">Admin Role</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-shield fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= count(array_filter($roles, fn($role) => strpos($role['name'], 'guru') !== false)) ?></div>
                    <div class="stats-label">Role Guru</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Roles Table -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Role
                </h5>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control form-control-sm" placeholder="Cari role..." id="searchRole">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="rolesTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Role</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Pengguna</th>
                        <th>Dibuat</th>
                        <th>Diupdate</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="role-icon me-3">
                                    <?php
                                    $roleIcons = [
                                        'super_admin' => 'fas fa-crown text-danger',
                                        'kepala_sekolah' => 'fas fa-user-tie text-warning',
                                        'guru_bk' => 'fas fa-heart text-info',
                                        'guru_mapel' => 'fas fa-book text-success',
                                        'wali_kelas' => 'fas fa-users text-primary',
                                        'wali_murid' => 'fas fa-home text-secondary',
                                        'murid' => 'fas fa-user-graduate text-dark'
                                    ];
                                    $iconClass = $roleIcons[$role['name']] ?? 'fas fa-user text-muted';
                                    ?>
                                    <i class="<?= $iconClass ?>"></i>
                                </div>
                                <div>
                                    <strong><?= ucwords(str_replace('_', ' ', $role['name'])) ?></strong>
                                    <br><small class="text-muted"><?= $role['name'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-truncate" style="max-width: 200px; display: inline-block;" title="<?= $role['description'] ?>">
                                <?= $role['description'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary"><?= $role['user_count'] ?> pengguna</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?= date('d M Y', strtotime($role['created_at'])) ?>
                            </small>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?= date('d M Y', strtotime($role['updated_at'])) ?>
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/roles/edit/<?= $role['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($role['user_count'] == 0): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteRole(<?= $role['id'] ?>, '<?= $role['name'] ?>')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php else: ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Tidak dapat dihapus - sedang digunakan">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Role Details Modal -->
<div class="modal fade" id="roleDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="roleDetailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus role <strong id="roleName"></strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="post" id="deleteForm" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .role-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37, 99, 235, 0.1);
        border-radius: 50%;
        font-size: 1.2rem;
    }

    .table th {
        font-weight: 600;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
    }

    .table td {
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-group .btn {
        margin-right: 2px;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    function deleteRole(id, name) {
        document.getElementById('roleName').textContent = name;
        document.getElementById('deleteForm').action = '/admin/roles/delete/' + id;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Search functionality
    document.getElementById('searchRole').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#rolesTable tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
