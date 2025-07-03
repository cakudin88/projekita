<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header dengan Greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users text-primary me-2"></i>
            Selamat datang, <?= esc(session()->get('full_name')) ?>!
        </h1>
        <div class="d-none d-lg-inline-block">
            <small class="text-muted">Wali Kelas • <?= date('d F Y') ?></small>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Total Siswa Kelas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Siswa Kelas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['class_students']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hadir Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['present_today']) ?>
                            </div>
                            <div class="text-xs text-success">
                                <?= number_format(($stats['present_today']/$stats['class_students'])*100, 1) ?>% dari total
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tidak Hadir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['absent_today']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perlu Konseling -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Perlu Konseling
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['counseling_needed']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
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
                            <a href="#" class="btn btn-primary btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>Input Absensi
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/counseling_requests/create" class="btn btn-warning btn-block">
                                <i class="fas fa-comments me-2"></i>Ajukan Konseling
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-info btn-block">
                                <i class="fas fa-phone me-2"></i>Hubungi Orang Tua
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-file-alt me-2"></i>Laporan Kelas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Ringkasan Kelas -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Ringkasan Kelas
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($class_summary) && !empty($class_summary)): ?>
                        <div class="row">
                            <?php foreach ($class_summary as $summary): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="border-left-primary p-3" style="border-left-width: 3px !important;">
                                        <h6 class="mb-1"><?= esc($summary['category'] ?? 'Kategori') ?></h6>
                                        <div class="d-flex justify-content-between">
                                            <span><?= esc($summary['description'] ?? 'Deskripsi') ?></span>
                                            <strong><?= esc($summary['value'] ?? '0') ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border-left-success p-3" style="border-left-width: 3px !important;">
                                    <h6 class="mb-1">Prestasi Akademik</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Rata-rata nilai kelas</span>
                                        <strong>83.2</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border-left-info p-3" style="border-left-width: 3px !important;">
                                    <h6 class="mb-1">Kehadiran</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Rata-rata kehadiran</span>
                                        <strong>92%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border-left-warning p-3" style="border-left-width: 3px !important;">
                                    <h6 class="mb-1">Kedisiplinan</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Pelanggaran bulan ini</span>
                                        <strong>3</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border-left-danger p-3" style="border-left-width: 3px !important;">
                                    <h6 class="mb-1">Perhatian Khusus</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Siswa perlu bimbingan</span>
                                        <strong>5</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Agenda & Jadwal -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Agenda Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">07:30</h6>
                                <p class="timeline-text">Cek kehadiran siswa</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">10:00</h6>
                                <p class="timeline-text">Meeting dengan Guru BK</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">13:00</h6>
                                <p class="timeline-text">Supervisi kelas</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">15:30</h6>
                                <p class="timeline-text">Konsultasi orang tua</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Kehadiran dan Masalah Siswa -->
    <div class="row">
        <!-- Laporan Kehadiran -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Laporan Kehadiran Mingguan
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($attendance_report) && !empty($attendance_report)): ?>
                        <?php foreach ($attendance_report as $day): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark font-weight-bold"><?= esc($day['day'] ?? 'Senin') ?></span>
                                    <span class="text-dark"><?= $day['percentage'] ?? 95 ?>%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $day['percentage'] ?? 95 ?>%" 
                                         aria-valuenow="<?= $day['percentage'] ?? 95 ?>" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Senin</span>
                                <span class="text-dark">95%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 95%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Selasa</span>
                                <span class="text-dark">88%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 88%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Rabu</span>
                                <span class="text-dark">92%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 92%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Kamis</span>
                                <span class="text-dark">97%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 97%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark font-weight-bold">Jumat</span>
                                <span class="text-dark">85%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Masalah Siswa -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-exclamation-circle me-2"></i>Masalah Siswa Terkini
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($student_issues) && !empty($student_issues)): ?>
                        <?php foreach ($student_issues as $issue): ?>
                            <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?= esc($issue['student_name'] ?? 'Nama Siswa') ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i><?= esc($issue['issue'] ?? 'Masalah siswa') ?>
                                        </small>
                                    </div>
                                    <span class="badge badge-<?= $issue['priority'] == 'high' ? 'danger' : ($issue['priority'] == 'medium' ? 'warning' : 'info') ?>">
                                        <?= esc($issue['priority'] ?? 'medium') ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Ahmad Fauzi</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Sering terlambat masuk kelas
                                    </small>
                                </div>
                                <span class="badge badge-warning">Medium</span>
                            </div>
                        </div>
                        <div class="border-left-danger p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Siti Nurhaliza</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Nilai menurun drastis
                                    </small>
                                </div>
                                <span class="badge badge-danger">High</span>
                            </div>
                        </div>
                        <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Budi Santoso</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Kesulitan dalam matematika
                                    </small>
                                </div>
                                <span class="badge badge-info">Low</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-check me-2"></i>Statistik Bulan Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-calendar-week fa-2x text-primary mb-2"></i>
                                <h5 class="font-weight-bold"><?= number_format($stats['parent_meetings']) ?></h5>
                                <small class="text-muted">Pertemuan Orang Tua</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-bell fa-2x text-warning mb-2"></i>
                                <h5 class="font-weight-bold"><?= number_format($stats['academic_alerts']) ?></h5>
                                <small class="text-muted">Peringatan Akademik</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-trophy fa-2x text-success mb-2"></i>
                                <h5 class="font-weight-bold">12</h5>
                                <small class="text-muted">Prestasi Siswa</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                <h5 class="font-weight-bold">95%</h5>
                                <small class="text-muted">Kepuasan Siswa</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.timeline-text {
    font-size: 0.8rem;
    margin-bottom: 0;
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>
