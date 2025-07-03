<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header dengan Greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-home text-primary me-2"></i>
            Selamat datang, <?= esc(session()->get('full_name')) ?>!
        </h1>
        <div class="d-none d-lg-inline-block">
            <small class="text-muted">Orang Tua • <?= date('d F Y') ?></small>
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
                                <?= number_format($stats['child_attendance']) ?>%
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

        <!-- Tugas Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tugas Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['homework_completed']) ?>
                            </div>
                            <div class="text-xs text-info">
                                <?= number_format($stats['homework_pending']) ?> belum selesai
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan Guru -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Catatan Guru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($stats['teacher_notes']) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sticky-note fa-2x text-gray-300"></i>
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
                            <a href="/profile" class="btn btn-primary btn-block">
                                <i class="fas fa-user me-2"></i>Lihat Profil Anak
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-chart-bar me-2"></i>Lihat Nilai
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-info btn-block">
                                <i class="fas fa-calendar-check me-2"></i>Cek Kehadiran
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fas fa-comments me-2"></i>Hubungi Guru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Perkembangan Anak -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-child me-2"></i>Perkembangan Anak
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($child_progress) && !empty($child_progress)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Aspek</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($child_progress as $progress): ?>
                                        <tr>
                                            <td><?= esc($progress['aspect'] ?? 'Aspek') ?></td>
                                            <td><?= esc($progress['score'] ?? '80') ?></td>
                                            <td>
                                                <span class="badge badge-<?= ($progress['score'] ?? 80) >= 80 ? 'success' : (($progress['score'] ?? 80) >= 70 ? 'warning' : 'danger') ?>">
                                                    <?= ($progress['score'] ?? 80) >= 80 ? 'Baik' : (($progress['score'] ?? 80) >= 70 ? 'Cukup' : 'Perlu Perbaikan') ?>
                                                </span>
                                            </td>
                                            <td><?= esc($progress['note'] ?? 'Perkembangan baik') ?></td>
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
                                        <th>Aspek</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Akademik</td>
                                        <td>85.2</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                        <td>Konsisten meningkat</td>
                                    </tr>
                                    <tr>
                                        <td>Kehadiran</td>
                                        <td>95</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                        <td>Sangat disiplin</td>
                                    </tr>
                                    <tr>
                                        <td>Perilaku</td>
                                        <td>88</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                        <td>Sopan dan patuh</td>
                                    </tr>
                                    <tr>
                                        <td>Sosial</td>
                                        <td>82</td>
                                        <td><span class="badge badge-success">Baik</span></td>
                                        <td>Bergaul dengan baik</td>
                                    </tr>
                                </tbody>
                            </table>
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
                        <i class="fas fa-calendar-alt me-2"></i>Agenda Terkini
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($upcoming_events) && !empty($upcoming_events)): ?>
                        <?php foreach ($upcoming_events as $event): ?>
                            <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                                <h6 class="mb-1"><?= esc($event['title'] ?? 'Event') ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i><?= esc($event['date'] ?? date('d M Y')) ?> | 
                                    <i class="fas fa-clock me-1"></i><?= esc($event['time'] ?? '08:00') ?>
                                </small>
                                <p class="mt-2 mb-0 small"><?= esc($event['description'] ?? 'Deskripsi event') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-primary p-3 mb-3" style="border-left-width: 3px !important;">
                            <h6 class="mb-1">Ujian Matematika</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>28 Des 2024 | 
                                <i class="fas fa-clock me-1"></i>08:00
                            </small>
                            <p class="mt-2 mb-0 small">Ujian tengah semester mata pelajaran matematika</p>
                        </div>
                        <div class="border-left-success p-3 mb-3" style="border-left-width: 3px !important;">
                            <h6 class="mb-1">Pertemuan Orang Tua</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>30 Des 2024 | 
                                <i class="fas fa-clock me-1"></i>09:00
                            </small>
                            <p class="mt-2 mb-0 small">Pembahasan perkembangan siswa semester ini</p>
                        </div>
                        <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                            <h6 class="mb-1">Libur Sekolah</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>1-7 Jan 2025 | 
                                <i class="fas fa-clock me-1"></i>Sepanjang hari
                            </small>
                            <p class="mt-2 mb-0 small">Libur semester dan tahun baru</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Komunikasi dengan Guru -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comments me-2"></i>Komunikasi dengan Guru
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (isset($teacher_communications) && !empty($teacher_communications)): ?>
                        <?php foreach ($teacher_communications as $comm): ?>
                            <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1"><?= esc($comm['teacher_name'] ?? 'Nama Guru') ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i><?= esc($comm['date'] ?? date('d M Y')) ?>
                                        </small>
                                        <p class="mt-2 mb-0"><?= esc($comm['message'] ?? 'Pesan dari guru') ?></p>
                                    </div>
                                    <span class="badge badge-<?= $comm['type'] == 'positive' ? 'success' : ($comm['type'] == 'warning' ? 'warning' : 'info') ?>">
                                        <?= esc($comm['type'] ?? 'info') ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="border-left-success p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Bu Sari (Wali Kelas)</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>26 Des 2024
                                    </small>
                                    <p class="mt-2 mb-0">Anak Anda menunjukkan perkembangan yang baik dalam bidang matematika. Pertahankan!</p>
                                </div>
                                <span class="badge badge-success">Positif</span>
                            </div>
                        </div>
                        <div class="border-left-warning p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Pak Budi (Guru BK)</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>24 Des 2024
                                    </small>
                                    <p class="mt-2 mb-0">Mohon perhatian untuk kedisiplinan waktu. Anak sering terlambat masuk kelas.</p>
                                </div>
                                <span class="badge badge-warning">Perhatian</span>
                            </div>
                        </div>
                        <div class="border-left-info p-3 mb-3" style="border-left-width: 3px !important;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Bu Ani (Guru IPA)</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>22 Des 2024
                                    </small>
                                    <p class="mt-2 mb-0">Reminder: Tugas praktikum IPA harus dikumpulkan besok pagi.</p>
                                </div>
                                <span class="badge badge-info">Info</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistik Tambahan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Ringkasan Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-medal fa-2x text-warning mb-2"></i>
                                <h5 class="font-weight-bold">8</h5>
                                <small class="text-muted">Prestasi Bulan Ini</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                <h5 class="font-weight-bold"><?= number_format($stats['counseling_sessions']) ?></h5>
                                <small class="text-muted">Sesi Konseling</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-book fa-2x text-success mb-2"></i>
                                <h5 class="font-weight-bold">15</h5>
                                <small class="text-muted">Buku Dipinjam</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <h5 class="font-weight-bold">25</h5>
                                <small class="text-muted">Kegiatan Ekstrakurikuler</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Semester -->
                    <div class="mt-4">
                        <h6 class="font-weight-bold mb-3">Progress Semester</h6>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark">Penyelesaian Kurikulum</span>
                                <span class="text-dark">75%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-dark">Target Nilai</span>
                                <span class="text-dark">85%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
