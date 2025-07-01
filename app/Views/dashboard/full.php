<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="welcome-header text-center">
            <h1 class="h2 mb-2">🎉 Selamat Datang, <?= session()->get('full_name') ?>! 🎉</h1>
            <p class="mb-2 fs-5">
                Anda login sebagai <strong><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></strong>
            </p>
            <div class="row text-center mt-3">
                <div class="col-md-6">
                    <small class="d-block">
                        <i class="fas fa-calendar me-1"></i>
                        <?= date('l, d F Y') ?>
                    </small>
                </div>
                <div class="col-md-6">
                    <small class="d-block">
                        <i class="fas fa-clock me-1"></i>
                        <?= date('H:i') ?> WIB
                    </small>
                </div>
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
                    <div class="stats-number"><?= isset($stats['total_roles']) ? $stats['total_roles'] : 0 ?></div>
                    <div class="stats-label">Total Role</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-tag fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= isset($stats['total_murid']) ? $stats['total_murid'] : 0 ?></div>
                    <div class="stats-label">Total Murid</div>
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
                    <div class="stats-number"><?= isset($stats['guru_count']) ? $stats['guru_count'] : 0 ?></div>
                    <div class="stats-label">Total Guru</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= isset($stats['active_users']) ? $stats['active_users'] : 0 ?></div>
                    <div class="stats-label">Pengguna Aktif</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
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
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Status Sistem</strong></td>
                        <td>: <span class="badge bg-success">Online</span></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Login</strong></td>
                        <td>: <?= date('d F Y, H:i') ?> WIB</td>
                    </tr>
                    <tr>
                        <td><strong>Total Pengguna</strong></td>
                        <td>: <?= isset($stats['total_users']) ? $stats['total_users'] : 0 ?> orang</td>
                    </tr>
                    <tr>
                        <td><strong>Pengguna Aktif</strong></td>
                        <td>: <?= isset($stats['active_users']) ? $stats['active_users'] : 0 ?> orang</td>
                    </tr>
                    <tr>
                        <td><strong>Database</strong></td>
                        <td>: <span class="badge bg-success">Connected</span></td>
                    </tr>
                </table>
                
                <hr>
                
                <div class="d-grid gap-2">
                    <a href="/dashboard/profile" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user me-2"></i>Lihat Profile Lengkap
                    </a>
                    <?php if (session()->get('role_name') == 'super_admin'): ?>
                    <a href="/optimize/status" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chart-line me-2"></i>Status Performance
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

<!-- Custom CSS for Enhanced Dashboard -->
<style>
.stats-card {
    border-radius: 15px;
    padding: 1.5rem;
    color: white;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.stats-icon {
    opacity: 0.7;
}

.card {
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: none;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.card-header {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-bottom: 1px solid #e2e8f0;
    border-radius: 15px 15px 0 0 !important;
}

.btn-outline-primary:hover,
.btn-outline-secondary:hover,
.btn-outline-success:hover,
.btn-outline-warning:hover,
.btn-outline-info:hover,
.btn-outline-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.table-borderless td {
    padding: 0.75rem 0;
    border: none;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
}

.list-group-item {
    border: none;
    border-radius: 8px !important;
    margin-bottom: 0.5rem;
}

.list-group-item:hover {
    background-color: #f8fafc;
    transform: translateX(5px);
}

/* Animated background for header */
.welcome-header {
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .stats-number {
        font-size: 2rem;
    }
    
    .stats-card {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>

<?= $this->endSection() ?>
