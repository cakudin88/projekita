<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Dashboard Bimbingan Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Dashboard BK!</strong> Sistem Bimbingan dan Konseling SMP Negeri 1 Pasuruan
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h4><?= $stats['total_sessions'] ?? 0 ?></h4>
                                    <p>Total Sesi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h4><?= $stats['total_students'] ?? 0 ?></h4>
                                    <p>Total Siswa</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h4><?= $stats['pending_sessions'] ?? 0 ?></h4>
                                    <p>Tertunda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h4><?= $stats['urgent_sessions'] ?? 0 ?></h4>
                                    <p>Mendesak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="card">
                        <div class="card-header">
                            <h6>Kategori Konseling</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if (isset($categories) && is_array($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                    <div class="col-md-4 mb-2">
                                        <span class="badge bg-secondary me-2"><?= $category['code'] ?? 'N/A' ?></span>
                                        <?= $category['name'] ?? 'Unknown' ?>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada data kategori.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6>Aksi Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2 d-md-flex">
                                <a href="/counseling/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Sesi Baru
                                </a>
                                <a href="/counseling/sessions" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>Lihat Semua Sesi
                                </a>
                                <a href="/counseling/reports" class="btn btn-outline-success">
                                    <i class="fas fa-chart-bar me-2"></i>Laporan BK
                                </a>
                                <a href="/counseling/records" class="btn btn-outline-info">
                                    <i class="fas fa-folder-open me-2"></i>Rekam Jejak
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
