<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Dashboard Bimbingan Konseling</h1>
                <p class="text-muted mb-0">SMP Negeri 1 Pasuruan - Sistem Bimbingan dan Konseling</p>
            </div>
            <div>
                <?php if (in_array($user_role, ['guru_bk', 'super_admin'])): ?>
                <a href="/counseling/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Sesi Baru
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['total_sessions'] ?></div>
                    <div class="stats-label">Total Sesi</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-comments fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['today_sessions'] ?></div>
                    <div class="stats-label">Hari Ini</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['pending_sessions'] ?></div>
                    <div class="stats-label">Tertunda</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stats-number"><?= $stats['urgent_sessions'] ?></div>
                    <div class="stats-label">Mendesak</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Left Column -->
    <div class="col-xl-8 col-lg-7">
        <!-- Upcoming Sessions -->
        <?php if (!empty($upcoming_sessions)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Sesi Mendatang
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Siswa</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Prioritas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_sessions as $session): ?>
                            <tr>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($session['session_date'])) ?><br>
                                        <?= date('H:i', strtotime($session['session_date'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= $session['student_name'] ?></strong><br>
                                        <small class="text-muted"><?= $session['nis'] ?> - <?= $session['class'] ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?= $session['category_color'] ?>;">
                                        <?= $session['category_name'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = [
                                        'scheduled' => 'bg-primary',
                                        'ongoing' => 'bg-warning',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger'
                                    ];
                                    $statusText = [
                                        'scheduled' => 'Terjadwal',
                                        'ongoing' => 'Berlangsung',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
                                    ];
                                    ?>
                                    <span class="badge <?= $statusClass[$session['status']] ?>">
                                        <?= $statusText[$session['status']] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($session['is_urgent']): ?>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Mendesak
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/counseling/view/<?= $session['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if (in_array($user_role, ['guru_bk', 'super_admin'])): ?>
                                        <a href="/counseling/edit/<?= $session['id'] ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
        <?php endif; ?>

        <!-- Recent Sessions -->
        <?php if (!empty($recent_sessions)): ?>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Sesi Terbaru
                        </h5>
                    </div>
                    <div class="col-auto">
                        <a href="/counseling/sessions" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($recent_sessions, 0, 5) as $session): ?>
                            <tr>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($session['session_date'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= $session['student_name'] ?></strong><br>
                                        <small class="text-muted"><?= $session['class'] ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?= $session['title'] ?>
                                    <?php if ($session['is_urgent']): ?>
                                        <i class="fas fa-exclamation-triangle text-danger ms-1" title="Mendesak"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?= $session['category_color'] ?>;">
                                        <?= $session['category_name'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $statusClass[$session['status']] ?>">
                                        <?= $statusText[$session['status']] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Column -->
    <div class="col-xl-4 col-lg-5">
        <!-- Categories -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tags me-2"></i>Kategori Konseling
                </h5>
            </div>
            <div class="card-body">
                <?php foreach ($categories as $category): ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="category-color me-3" style="width: 16px; height: 16px; background-color: <?= $category['color'] ?>; border-radius: 50%;"></div>
                    <div class="flex-grow-1">
                        <strong><?= $category['name'] ?></strong><br>
                        <small class="text-muted"><?= $category['description'] ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <?php if (in_array($user_role, ['guru_bk', 'super_admin'])): ?>
                <div class="d-grid gap-2">
                    <a href="/counseling/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Buat Sesi Baru
                    </a>
                    <a href="/counseling/emergency" class="btn btn-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Sesi Darurat
                    </a>
                    <a href="/counseling/reports" class="btn btn-info">
                        <i class="fas fa-chart-line me-2"></i>Buat Laporan
                    </a>
                </div>
                <?php endif; ?>
                
                <?php if ($user_role === 'kepala_sekolah'): ?>
                <div class="d-grid gap-2">
                    <a href="/counseling/reports" class="btn btn-primary">
                        <i class="fas fa-chart-line me-2"></i>Lihat Laporan
                    </a>
                    <a href="/counseling/statistics" class="btn btn-info">
                        <i class="fas fa-chart-pie me-2"></i>Statistik BK
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .stats-card {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 120px;
        display: flex;
        align-items: center;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .stats-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    .stats-icon {
        opacity: 0.7;
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

    .category-color {
        border: 2px solid #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card {
        border: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 10px 10px 0 0 !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
<?= $this->endSection() ?>
