<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Selamat Datang, <?= session()->get('full_name') ?>!</h1>
                <p class="text-muted mb-0">
                    Anda login sebagai <strong><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></strong>
                </p>
            </div>
            <div class="text-end">
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    <?= date('l, d F Y') ?>
                </small>
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
                    <div class="stats-number"><?= $stats['total_users'] ?? 0 ?></div>
                    <div class="stats-label">Total Pengguna</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #6366f1, #3b82f6);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['total_roles'] ?? 0 ?></div>
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
                    <div class="stats-number"><?= $stats['total_siswa'] ?? 0 ?></div>
                    <div class="stats-label">Total Siswa</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['guru_count'] ?? 0 ?></div>
                    <div class="stats-label">Total Guru</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Akun
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nama Lengkap</strong></td>
                        <td>: <?= session()->get('full_name') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Username</strong></td>
                        <td>: <?= session()->get('username') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: <?= session()->get('email') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td>: <?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if (session()->get('role_name') == 'super_admin'): ?>
                    <a href="/admin/users" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>Kelola Pengguna
                    </a>
                    <a href="/admin/roles" class="btn btn-outline-secondary">
                        <i class="fas fa-user-tag me-2"></i>Kelola Role
                    </a>
                    <?php endif; ?>
                    
                    <?php if (in_array(session()->get('role_name'), ['kepala_sekolah', 'guru_bk', 'wali_kelas'])): ?>
                    <a href="/students" class="btn btn-outline-success">
                        <i class="fas fa-user-graduate me-2"></i>Data Siswa
                    </a>
                    <a href="/teachers" class="btn btn-outline-info">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Data Guru
                    </a>
                    <?php endif; ?>
                    
                    <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin', 'kepala_sekolah'])): ?>
                    <a href="/counseling" class="btn btn-outline-warning">
                        <i class="fas fa-heart me-2"></i>Bimbingan Konseling
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin', 'kepala_sekolah'])): ?>
<!-- Counseling Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-heart me-2"></i>Bimbingan Konseling - Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="/counseling/sessions" class="list-group-item list-group-item-action">
                        <i class="fas fa-comments me-2"></i>Lihat Semua Sesi Konseling
                    </a>
                    <a href="/counseling/create" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i>Buat Sesi Konseling Baru
                    </a>
                    <a href="/appointments" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Konseling
                    </a>
                    <a href="/counseling/categories" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i>Kategori Konseling
                    </a>
                    <a href="/counseling/reports" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line me-2"></i>Laporan BK
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
