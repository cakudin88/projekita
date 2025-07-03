<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header dengan Greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-graduation-cap text-primary me-2"></i>
            Selamat datang, <?= esc(session()->get('full_name')) ?>!
        </h1>
        <div class="d-none d-lg-inline-block">
            <small class="text-muted">Siswa • <?= date('d F Y') ?></small>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Tingkat Kehadiran -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tingkat Kehadiran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['attendance_rate']) ?>%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Nilai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Rata-rata Nilai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['avg_grade'], 1) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas Menunggu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tugas Menunggu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['assignments_due']) ?>
                            </div>
                            <div class="text-xs text-success">
                                <?= number_format($stats['completed_assignments']) ?> selesai
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Prestasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['achievements']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
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
                            <a href="/counseling_requests/create" class="btn btn-primary btn-block">
                                <i class="fas fa-hand-holding-heart me-2"></i>Ajukan Konseling
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/counseling_requests" class="btn btn-success btn-block">
                                <i class="fas fa-clock me-2"></i>Status Konseling
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/chat" class="btn btn-info btn-block">
                                <i class="fas fa-comments me-2"></i>Chat Guru BK
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/incident_reports/create" class="btn btn-warning btn-block">
                                <i class="fas fa-exclamation-triangle me-2"></i>Lapor Kejadian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Jadwal Hari Ini -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($schedule_today) && !empty($schedule_today)): ?>
                        <?php foreach ($schedule_today as $schedule): ?>
                            <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?= esc($schedule['subject'] ?? 'Mata Pelajaran') ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i><?= esc($schedule['time'] ?? '08:00 - 09:30') ?> | 
                                            <i class="fas fa-door-open me-1"></i><?= esc($schedule['room'] ?? 'Ruang 101') ?>
                                        </small>
                                    </div>
                                    <span class="badge badge-primary"><?= esc($schedule['teacher'] ?? 'Guru') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Matematika</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>08:00 - 09:30 | 
                                        <i class="fas fa-door-open me-1"></i>Ruang 101
                                    </small>
                                </div>
                                <span class="badge badge-primary">Pak Budi</span>
                            </div>
                        </div>
                        <div class="border-left-success p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Bahasa Indonesia</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>09:30 - 11:00 | 
                                        <i class="fas fa-door-open me-1"></i>Ruang 101
                                    </small>
                                </div>
                                <span class="badge badge-success">Bu Sari</span>
                            </div>
                        </div>
                        <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">IPA</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>13:00 - 14:30 | 
                                        <i class="fas fa-door-open me-1"></i>Lab IPA
                                    </small>
                                </div>
                                <span class="badge badge-info">Bu Ani</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tugas Mendatang -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks me-2"></i>Tugas Mendatang
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($upcoming_assignments) && !empty($upcoming_assignments)): ?>
                        <?php foreach ($upcoming_assignments as $assignment): ?>
                            <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?= esc($assignment['title'] ?? 'Tugas') ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-book me-1"></i><?= esc($assignment['subject'] ?? 'Mata Pelajaran') ?> | 
                                            <i class="fas fa-calendar me-1"></i>Deadline: <?= esc($assignment['deadline'] ?? date('d M Y')) ?>
                                        </small>
                                    </div>
                                    <span class="badge badge-<?= (strtotime($assignment['deadline'] ?? 'tomorrow') - time()) < 86400 ? 'danger' : 'warning' ?>">
                                        <?= (strtotime($assignment['deadline'] ?? 'tomorrow') - time()) < 86400 ? 'Urgent' : 'Soon' ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Tugas Matematika</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-book me-1"></i>Matematika | 
                                        <i class="fas fa-calendar me-1"></i>Deadline: 30 Des 2024
                                    </small>
                                </div>
                                <span class="badge badge-warning">Soon</span>
                            </div>
                        </div>
                        <div class="border-left-danger p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Laporan IPA</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-book me-1"></i>IPA | 
                                        <i class="fas fa-calendar me-1"></i>Deadline: 28 Des 2024
                                    </small>
                                </div>
                                <span class="badge badge-danger">Urgent</span>
                            </div>
                        </div>
                        <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Essay Bahasa Indonesia</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-book me-1"></i>Bahasa Indonesia | 
                                        <i class="fas fa-calendar me-1"></i>Deadline: 5 Jan 2025
                                    </small>
                                </div>
                                <span class="badge badge-info">Normal</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Terbaru dan Status Konseling -->
    <div class="row">
        <!-- Nilai Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Nilai Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($recent_grades) && !empty($recent_grades)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_grades as $grade): ?>
                                        <tr>
                                            <td><?= esc($grade['subject'] ?? 'Mata Pelajaran') ?></td>
                                            <td><?= esc($grade['type'] ?? 'Tugas') ?></td>
                                            <td><?= esc($grade['score'] ?? '80') ?></td>
                                            <td>
                                                <span class="badge badge-<?= ($grade['score'] ?? 80) >= 80 ? 'success' : (($grade['score'] ?? 80) >= 70 ? 'warning' : 'danger') ?>">
                                                    <?= ($grade['score'] ?? 80) >= 80 ? 'Baik' : (($grade['score'] ?? 80) >= 70 ? 'Cukup' : 'Perlu Perbaikan') ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Matematika</td>
                                        <td>Ulangan</td>
                                        <td>85</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                    </tr>
                                    <tr>
                                        <td>Bahasa Indonesia</td>
                                        <td>Tugas</td>
                                        <td>88</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                    </tr>
                                    <tr>
                                        <td>IPA</td>
                                        <td>Praktikum</td>
                                        <td>78</td>
                                        <td><span class="badge badge-warning">Cukup</span></td>
                                    </tr>
                                    <tr>
                                        <td>IPS</td>
                                        <td>Ulangan</td>
                                        <td>82</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Status Konseling -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-heart me-2"></i>Status Konseling & Bimbingan
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($counseling_status) && !empty($counseling_status) && $counseling_status['status'] !== 'none' && $counseling_status['status'] !== 'error'): ?>
                        <div class="border-left-<?= $counseling_status['status'] == 'scheduled' ? 'success' : ($counseling_status['status'] == 'pending' ? 'warning' : 'info') ?> p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1"><?= esc($counseling_status['theme'] ?? 'Topik Konseling') ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i><?= esc($counseling_status['description'] ?? 'Deskripsi konseling') ?>
                                        <?php if (isset($counseling_status['counseling_date']) && !empty($counseling_status['counseling_date'])): ?>
                                            <br><i class="fas fa-calendar me-1"></i><?= date('d M Y H:i', strtotime($counseling_status['counseling_date'])) ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <span class="badge badge-<?= $counseling_status['status'] == 'scheduled' ? 'success' : ($counseling_status['status'] == 'pending' ? 'warning' : ($counseling_status['status'] == 'completed' ? 'info' : 'secondary')) ?>">
                                    <?= esc(ucfirst($counseling_status['status'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <?php if (!empty($counseling_status['response_message'])): ?>
                            <div class="alert alert-info">
                                <strong>Pesan dari Guru BK:</strong><br>
                                <?= esc($counseling_status['response_message']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($counseling_status['rejected_reason'])): ?>
                            <div class="alert alert-warning">
                                <strong>Alasan Penolakan:</strong><br>
                                <?= esc($counseling_status['rejected_reason']) ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-heart fa-3x text-gray-400 mb-3"></i>
                            <p class="text-muted mb-3">
                                <?= isset($counseling_status['message']) ? esc($counseling_status['message']) : 'Belum ada konseling yang dijadwalkan' ?>
                            </p>
                            <a href="/counseling_requests/create" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Ajukan Konseling
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Quick Stats -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <h6 class="font-weight-bold text-primary"><?= number_format($stats['counseling_sessions']) ?></h6>
                                <small class="text-muted">Total Sesi</small>
                            </div>
                            <div class="col-4">
                                <h6 class="font-weight-bold text-success">
                                    <?php 
                                    $completedSessions = 0;
                                    if (isset($counseling_status) && is_array($counseling_status) && isset($counseling_status['status']) && $counseling_status['status'] == 'completed') {
                                        $completedSessions = 1;
                                    }
                                    echo $completedSessions;
                                    ?>
                                </h6>
                                <small class="text-muted">Selesai</small>
                            </div>
                            <div class="col-4">
                                <h6 class="font-weight-bold text-warning">
                                    <?php 
                                    $pendingSessions = 0;
                                    if (isset($counseling_status) && is_array($counseling_status) && isset($counseling_status['status']) && $counseling_status['status'] == 'pending') {
                                        $pendingSessions = 1;
                                    }
                                    echo $pendingSessions;
                                    ?>
                                </h6>
                                <small class="text-muted">Menunggu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Aktivitas -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-check me-2"></i>Ringkasan Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <h5 class="font-weight-bold">12</h5>
                                <small class="text-muted">Buku Dipinjam</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                <h5 class="font-weight-bold">3</h5>
                                <small class="text-muted">Ekstrakurikuler</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-certificate fa-2x text-warning mb-2"></i>
                                <h5 class="font-weight-bold">8</h5>
                                <small class="text-muted">Sertifikat</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-star fa-2x text-info mb-2"></i>
                                <h5 class="font-weight-bold">4.5</h5>
                                <small class="text-muted">Rating Perilaku</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Goals -->
                    <div class="mt-4">
                        <h6 class="font-weight-bold mb-3">Target Semester</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark">Target Nilai Rata-rata (85)</span>
                                    <span class="text-dark"><?= number_format($stats['avg_grade'], 1) ?></span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar <?= $stats['avg_grade'] >= 85 ? 'bg-success' : 'bg-warning' ?>" 
                                         role="progressbar" style="width: <?= min(($stats['avg_grade']/85)*100, 100) ?>%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-dark">Target Kehadiran (95%)</span>
                                    <span class="text-dark"><?= number_format($stats['attendance_rate']) ?>%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar <?= $stats['attendance_rate'] >= 95 ? 'bg-success' : 'bg-warning' ?>" 
                                         role="progressbar" style="width: <?= min(($stats['attendance_rate']/95)*100, 100) ?>%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
