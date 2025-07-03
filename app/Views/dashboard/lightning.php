<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Quick Stats -->
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0"><?= isset($stats['total_users']) ? $stats['total_users'] : 0 ?></h3>
                            <small>Pengguna</small>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0"><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : 0 ?></h3>
                            <small>Siswa</small>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0"><?= isset($stats['guru_count']) ? $stats['guru_count'] : 0 ?></h3>
                            <small>Guru</small>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0"><?= isset($stats['active_users']) ? $stats['active_users'] : 0 ?></h3>
                            <small>Aktif</small>
                        </div>
                        <i class="fas fa-user-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome & Quick Actions -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <h5>Selamat Datang, <?= session()->get('full_name') ?>!</h5>
                    <p class="text-muted mb-3">Role: <?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></p>
                    
                    <div class="row g-2">
                        <?php if (session()->get('role_name') == 'super_admin'): ?>
                        <div class="col-md-6">
                            <a href="/admin/users" class="btn btn-outline-primary w-100">
                                <i class="fas fa-users me-1"></i> Kelola Pengguna
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/admin/roles" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-user-tag me-1"></i> Kelola Role
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin'])): ?>
                        <div class="col-md-6">
                            <a href="/counseling" class="btn btn-outline-info w-100">
                                <i class="fas fa-heart me-1"></i> Dashboard BK
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/counseling/create" class="btn btn-outline-success w-100">
                                <i class="fas fa-plus me-1"></i> Sesi Baru
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-body">
                    <h6>Info Sistem</h6>
                    <small class="text-muted d-block">Tanggal: <?= date('d F Y') ?></small>
                    <small class="text-muted d-block">Status: <span class="text-success">Online</span></small>
                    
                    <hr class="my-2">
                    
                    <a href="/dashboard/profile" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-user me-1"></i> Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (ENVIRONMENT === 'development'): ?>
<div class="fixed-bottom p-2">
    <small class="text-muted">
        <?php $perf = get_performance_info(); ?>
        Memory: <?= $perf['memory_usage'] ?> | Time: <?= $perf['execution_time'] ?>
    </small>
</div>
<?php endif; ?>

<?= $this->endsection() ?>
