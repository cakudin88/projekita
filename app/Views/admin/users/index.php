<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Kelola Pengguna</h1>
                <p class="text-muted mb-0">Mengelola data pengguna sistem</p>
            </div>
            <div>
                <a href="/admin/users/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Pengguna
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
                    <div class="stats-number"><?= count($users) ?></div>
                    <div class="stats-label">Total Pengguna</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= count(array_filter($users, fn($user) => $user['is_active'] == 1)) ?></div>
                    <div class="stats-label">Pengguna Aktif</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= count(array_filter($users, fn($user) => $user['role_name'] == 'super_admin')) ?></div>
                    <div class="stats-label">Administrator</div>
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
                    <div class="stats-number"><?= count(array_filter($users, fn($user) => in_array($user['role_name'], ['guru_mapel', 'guru_bk', 'wali_kelas']))) ?></div>
                    <div class="stats-label">Guru</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Pengguna
                </h5>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="roleFilter">
                        <option value="">Semua Role</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="kepala_sekolah">Kepala Sekolah</option>
                        <option value="guru_bk">Guru BK</option>
                        <option value="guru_mapel">Guru Mapel</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="wali_murid">Wali Murid</option>
                        <option value="murid">Murid</option>
                    </select>
                    <input type="text" class="form-control form-control-sm" placeholder="Cari pengguna..." id="searchUser">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Avatar</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($users as $user): ?>
                    <tr data-role="<?= $user['role_name'] ?>">
                        <td><?= $no++ ?></td>
                        <td>
                            <div class="avatar-sm">
                                <?php if ($user['avatar']): ?>
                                    <img src="/uploads/avatars/<?= $user['avatar'] ?>" alt="Avatar" class="avatar-img">
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= $user['full_name'] ?></strong>
                                <?php if ($user['phone']): ?>
                                    <br><small class="text-muted"><?= $user['phone'] ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <?php
                            $roleColors = [
                                'super_admin' => 'danger',
                                'kepala_sekolah' => 'warning',
                                'guru_bk' => 'info',
                                'guru_mapel' => 'success',
                                'wali_kelas' => 'primary',
                                'wali_murid' => 'secondary',
                                'murid' => 'light text-dark'
                            ];
                            $badgeColor = $roleColors[$user['role_name']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $badgeColor ?>">
                                <?= ucwords(str_replace('_', ' ', $user['role_name'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['is_active']): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?= date('d M Y', strtotime($user['created_at'])) ?>
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteUser(<?= $user['id'] ?>, '<?= $user['full_name'] ?>')" title="Hapus">
                                    <i class="fas fa-trash"></i>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna <strong id="userName"></strong>?</p>
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
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .avatar-sm .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-sm .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
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
</style>

<script>
    function deleteUser(id, name) {
        document.getElementById('userName').textContent = name;
        document.getElementById('deleteForm').action = '/admin/users/delete/' + id;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Search functionality
    document.getElementById('searchUser').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#usersTable tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Role filter functionality
    document.getElementById('roleFilter').addEventListener('change', function() {
        const selectedRole = this.value;
        const tableRows = document.querySelectorAll('#usersTable tbody tr');
        
        tableRows.forEach(row => {
            const rowRole = row.getAttribute('data-role');
            if (selectedRole === '' || rowRole === selectedRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
