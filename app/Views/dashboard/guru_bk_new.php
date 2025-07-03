<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header dengan Greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-tie text-primary me-2"></i>
            Selamat datang, <?= esc(session()->get('full_name')) ?>!
        </h1>
        <div class="d-none d-lg-inline-block">
            <small class="text-muted">Guru Bimbingan Konseling • <?= date('d F Y') ?></small>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Permintaan Baru -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Permintaan Baru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['pending_requests']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jadwal Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['scheduled_sessions']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai Bulan Ini -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['completed_sessions']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Siswa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['total_students']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Insiden -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Laporan Insiden
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['incident_reports']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesan Baru -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Pesan Baru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['chat_messages']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="/counseling-requests/manage" class="btn btn-warning btn-block">
                                <i class="fas fa-tasks me-2"></i>Kelola Permintaan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/chat/select-murid" class="btn btn-primary btn-block">
                                <i class="fas fa-comments me-2"></i>Chat dengan Siswa
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/incident-reports/manage" class="btn btn-danger btn-block">
                                <i class="fas fa-exclamation-triangle me-2"></i>Laporan Insiden
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-chart-bar me-2"></i>Laporan Bulanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Jadwal Konseling Hari Ini -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Konseling Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($today_schedule) && !empty($today_schedule)): ?>
                        <?php foreach ($today_schedule as $schedule): ?>
                            <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?= esc($schedule['student'] ?? 'Ahmad Rizki') ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i><?= esc($schedule['time'] ?? '08:00') ?> | 
                                            <i class="fas fa-user me-1"></i><?= esc($schedule['topic'] ?? 'Konsultasi Akademik') ?>
                                        </small>
                                    </div>
                                    <span class="badge badge-primary">Detail</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Ahmad Rizki</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>08:00 | 
                                        <i class="fas fa-user me-1"></i>Konsultasi Akademik
                                    </small>
                                </div>
                                <span class="badge badge-primary">Detail</span>
                            </div>
                        </div>
                        <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Siti Nurhaliza</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>10:00 | 
                                        <i class="fas fa-user me-1"></i>Bimbingan Karir
                                    </small>
                                </div>
                                <span class="badge badge-primary">Detail</span>
                            </div>
                        </div>
                        <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Budi Santoso</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>13:00 | 
                                        <i class="fas fa-user me-1"></i>Masalah Sosial
                                    </small>
                                </div>
                                <span class="badge badge-primary">Detail</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Ringkasan Siswa -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i>Ringkasan Siswa
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($student_summary) && !empty($student_summary)): ?>
                        <?php foreach ($student_summary as $summary): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark font-weight-bold"><?= esc($summary['category'] ?? 'Kategori') ?></span>
                                    <span class="text-dark"><?= number_format($summary['count'] ?? 0) ?></span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-<?= $summary['color'] ?? 'primary' ?>" role="progressbar" 
                                         style="width: <?= ($summary['count'] ?? 0) / 10 * 100 ?>%" 
                                         aria-valuenow="<?= $summary['count'] ?? 0 ?>" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Perlu Perhatian</span>
                                <span class="text-dark">8</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Konseling Rutin</span>
                                <span class="text-dark">15</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Bermasalah</span>
                                <span class="text-dark">3</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list me-2"></i>Ringkasan Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                                <h5 class="font-weight-bold"><?= number_format($stats['completed_sessions']) ?></h5>
                                <small class="text-muted">Sesi Selesai</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-calendar-plus fa-2x text-primary mb-2"></i>
                                <h5 class="font-weight-bold"><?= number_format($stats['scheduled_sessions']) ?></h5>
                                <small class="text-muted">Jadwal Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                <h5 class="font-weight-bold">85%</h5>
                                <small class="text-muted">Tingkat Keberhasilan</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                <h5 class="font-weight-bold">4.9</h5>
                                <small class="text-muted">Rating Konseling</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
