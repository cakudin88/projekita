<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-0">Dashboard Guru Bimbingan Konseling</h1>
        <p class="text-muted">Kelola bimbingan konseling dan kesejahteraan siswa • <?= esc(session()->get('full_name')) ?></p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card bg-warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['pending_requests']) ?></h3>
                    <p class="mb-0">Permintaan Baru</p>
                </div>
                <div class="fs-2"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['scheduled_sessions']) ?></h3>
                    <p class="mb-0">Jadwal Hari Ini</p>
                </div>
                <div class="fs-2"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card bg-success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['completed_sessions']) ?></h3>
                    <p class="mb-0">Selesai Bulan Ini</p>
                </div>
                <div class="fs-2"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card bg-info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['total_students']) ?></h3>
                    <p class="mb-0">Total Siswa</p>
                </div>
                <div class="fs-2"><i class="fas fa-user-graduate"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card bg-danger">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['incident_reports']) ?></h3>
                    <p class="mb-0">Laporan Insiden</p>
                </div>
                <div class="fs-2"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card bg-secondary">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= number_format($stats['chat_messages']) ?></h3>
                    <p class="mb-0">Pesan Baru</p>
                </div>
                <div class="fs-2"><i class="fas fa-comments"></i></div>
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
                        <h4 class="text-warning"><?= number_format($stats['pending_requests']) ?></h4>
                        <p class="mb-0">Menunggu Persetujuan</p>
                    </div>
                    <div class="text-warning fs-3"><i class="fas fa-hourglass-half"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-success">85%</h4>
                        <p class="mb-0">Tingkat Keberhasilan</p>
                    </div>
                    <div class="text-success fs-3"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-info">4.9</h4>
                        <p class="mb-0">Rating Konseling</p>
                    </div>
                    <div class="text-info fs-3"><i class="fas fa-star"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Konseling Hari Ini -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal Konseling Hari Ini
                </h5>
            </div>
            <div class="card-body">
                <?php if (isset($today_schedule) && !empty($today_schedule)): ?>
                    <?php foreach ($today_schedule as $schedule): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="schedule-time me-3">
                                <span class="badge bg-primary"><?= esc($schedule['time'] ?? '08:00') ?></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= esc($schedule['student'] ?? 'Ahmad Rizki') ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i><?= esc($schedule['topic'] ?? 'Konsultasi Akademik') ?>
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
                            <span class="badge bg-primary">08:00</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Ahmad Rizki</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Konsultasi Akademik
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">Detail</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="schedule-time me-3">
                            <span class="badge bg-success">10:00</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Siti Nurhaliza</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Bimbingan Karir
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">Detail</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="schedule-time me-3">
                            <span class="badge bg-warning">13:00</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Budi Santoso</h6>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Masalah Sosial
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

    <!-- Aktivitas Terkini -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Aktivitas Terkini
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="activity-icon me-3">
                        <i class="fas fa-user-plus text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1">Permintaan konseling baru dari Ahmad Rizki</p>
                        <small class="text-muted">2 jam yang lalu</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="activity-icon me-3">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1">Sesi konseling dengan Siti selesai</p>
                        <small class="text-muted">4 jam yang lalu</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="activity-icon me-3">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1">Laporan insiden baru diterima</p>
                        <small class="text-muted">6 jam yang lalu</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="activity-icon me-3">
                        <i class="fas fa-comments text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1">Pesan chat baru dari orang tua</p>
                        <small class="text-muted">1 hari yang lalu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-4">
    <!-- Counseling Progress Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Progress Konseling Bulan Ini
                </h5>
            </div>
            <div class="card-body">
                <canvas id="counselingProgressChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Session Types Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Distribusi Jenis Konseling
                </h5>
            </div>
            <div class="card-body">
                <canvas id="sessionTypesChart" width="400" height="200"></canvas>
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
                        <a href="/counseling-requests/manage" class="btn btn-outline-warning w-100">
                            <i class="fas fa-tasks me-2"></i>Kelola Permintaan
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="/chat/select-murid" class="btn btn-outline-primary w-100">
                            <i class="fas fa-comments me-2"></i>Chat dengan Siswa
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="/incident-reports/manage" class="btn btn-outline-danger w-100">
                            <i class="fas fa-exclamation-triangle me-2"></i>Laporan Insiden
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="#" class="btn btn-outline-success w-100">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Bulanan
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
// Counseling Progress Chart
const ctx1 = document.getElementById('counselingProgressChart').getContext('2d');
const counselingProgressChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        datasets: [{
            label: 'Sesi Selesai',
            data: [8, 12, 15, 18],
            borderColor: '#059669',
            backgroundColor: 'rgba(5, 150, 105, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Permintaan Baru',
            data: [5, 9, 7, 11],
            borderColor: '#dc2626',
            backgroundColor: 'rgba(220, 38, 38, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Session Types Distribution Chart
const ctx2 = document.getElementById('sessionTypesChart').getContext('2d');
const sessionTypesChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Akademik', 'Karir', 'Sosial', 'Pribadi', 'Keluarga'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
