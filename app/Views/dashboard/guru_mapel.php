<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-0">Dashboard Guru Mata Pelajaran</h1>
        <p class="text-muted">Kelola pembelajaran dan evaluasi siswa • <?= esc(session()->get('full_name')) ?></p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['total_classes']) ?></h3>
                    <p class="mb-0">Total Kelas</p>
                </div>
                <div class="fs-2"><i class="fas fa-school"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['total_students']) ?></h3>
                    <p class="mb-0">Total Siswa</p>
                </div>
                <div class="fs-2"><i class="fas fa-user-graduate"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['assignments_pending']) ?></h3>
                    <p class="mb-0">Tugas Menunggu</p>
                </div>
                <div class="fs-2"><i class="fas fa-clipboard-list"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['avg_grade'], 1) ?></h3>
                    <p class="mb-0">Rata-rata Nilai</p>
                </div>
                <div class="fs-2"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-primary"><?= number_format($stats['upcoming_tests']) ?></h4>
                        <p class="mb-0">Ujian Mendatang</p>
                    </div>
                    <div class="text-primary fs-3"><i class="fas fa-tasks"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-success"><?= number_format($stats['completed_lessons']) ?></h4>
                        <p class="mb-0">Pelajaran Selesai</p>
                    </div>
                    <div class="text-success fs-3"><i class="fas fa-book"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-info">92%</h4>
                        <p class="mb-0">Tingkat Kehadiran</p>
                    </div>
                    <div class="text-info fs-3"><i class="fas fa-user-check"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Mengajar Hari Ini -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar Hari Ini
                </h5>
            </div>
            <div class="card-body">
                <?php if (isset($upcoming_schedule) && !empty($upcoming_schedule)): ?>
                    <?php foreach ($upcoming_schedule as $schedule): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="schedule-time me-3">
                                <span class="badge bg-primary"><?= esc($schedule['time'] ?? '08:00 - 09:30') ?></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= esc($schedule['subject'] ?? 'Mata Pelajaran') ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-door-open me-1"></i><?= esc($schedule['room'] ?? 'Ruang 101') ?> | 
                                    <i class="fas fa-users me-1"></i><?= esc($schedule['class'] ?? 'X IPA 1') ?>
                                </small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary">Detail</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="schedule-time me-3">
                            <span class="badge bg-primary">08:00 - 09:30</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Matematika</h6>
                            <small class="text-muted">
                                <i class="fas fa-door-open me-1"></i>Ruang 101 | 
                                <i class="fas fa-users me-1"></i>X IPA 1
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">Detail</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="schedule-time me-3">
                            <span class="badge bg-success">10:00 - 11:30</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Fisika</h6>
                            <small class="text-muted">
                                <i class="fas fa-door-open me-1"></i>Lab Fisika | 
                                <i class="fas fa-users me-1"></i>XI IPA 2
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">Detail</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="schedule-time me-3">
                            <span class="badge bg-warning">13:00 - 14:30</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Kimia</h6>
                            <small class="text-muted">
                                <i class="fas fa-door-open me-1"></i>Lab Kimia | 
                                <i class="fas fa-users me-1"></i>XII IPA 1
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">Detail</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Performa Kelas Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Performa Kelas
                </h5>
            </div>
            <div class="card-body">
                <canvas id="classPerformanceChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus-circle me-2"></i>Buat Tugas Baru
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-success w-100">
                            <i class="fas fa-chart-bar me-2"></i>Input Nilai
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-info w-100">
                            <i class="fas fa-calendar-check me-2"></i>Absensi Kelas
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-warning w-100">
                            <i class="fas fa-file-alt me-2"></i>Laporan Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Class Performance Chart
const ctx = document.getElementById('classPerformanceChart').getContext('2d');
const classPerformanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['X IPA 1', 'X IPA 2', 'XI IPA 1', 'XI IPA 2', 'XII IPA 1', 'XII IPA 2'],
        datasets: [{
            label: 'Rata-rata Nilai',
            data: [85, 78, 92, 88, 76, 90],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
