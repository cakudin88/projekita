<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid p-0">
    <!-- Welcome Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Selamat Datang, <?= session()->get('full_name') ?>!</h2>
                    <p class="text-muted mb-0">
                        Anda login sebagai <strong><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></strong>
                    </p>
                </div>
                <div class="text-end d-none d-md-block">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        <?= indonesian_date() ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards - Optimized Layout -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h4 mb-0 fw-bold"><?= isset($stats['total_users']) ? $stats['total_users'] : 0 ?></div>
                        <small class="opacity-75">Total Pengguna</small>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="background:linear-gradient(135deg,#10b981,#059669)">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h4 mb-0 fw-bold"><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : 0 ?></div>
                        <small class="opacity-75">Total Siswa</small>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h4 mb-0 fw-bold"><?= isset($stats['guru_count']) ? $stats['guru_count'] : 0 ?></div>
                        <small class="opacity-75">Total Guru</small>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h4 mb-0 fw-bold"><?= isset($stats['active_users']) ? $stats['active_users'] : 0 ?></div>
                        <small class="opacity-75">Pengguna Aktif</small>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <?php if (session()->get('role_name') == 'super_admin'): ?>
                        <div class="col-md-6">
                            <a href="/admin/users" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-users me-2"></i>
                                Kelola Pengguna
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/admin/roles" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-user-tag me-2"></i>
                                Kelola Role
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (in_array(session()->get('role_name'), ['kepala_sekolah', 'guru_bk', 'wali_kelas'])): ?>
                        <div class="col-md-6">
                            <a href="/students" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-user-graduate me-2"></i>
                                Data Siswa
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/teachers" class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Data Guru
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin', 'kepala_sekolah'])): ?>
                        <div class="col-md-6">
                            <a href="/counseling" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-heart me-2"></i>
                                Dashboard BK
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/counseling/create" class="btn btn-outline-purple w-100 d-flex align-items-center justify-content-start">
                                <i class="fas fa-plus-circle me-2"></i>
                                Sesi Konseling Baru
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Status Sistem:</span>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Tanggal:</span>
                        <span><?= indonesian_date() ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Role Aktif:</span>
                        <span class="badge bg-primary"><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <a href="/dashboard/profile" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user me-1"></i>
                            Lihat Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-outline-purple {
    color: #8b5cf6;
    border-color: #8b5cf6;
}
.btn-outline-purple:hover {
    background-color: #8b5cf6;
    border-color: #8b5cf6;
    color: white;
}
</style>

<?= $this->endsection() ?>
