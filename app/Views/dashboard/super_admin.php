<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-0">Dashboard Super Admin</h1>
        <p class="text-muted">Kelola seluruh sistem sekolah dan pantau aktivitas</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= $stats['total_users'] ?></h3>
                    <p class="mb-0">Total Pengguna</p>
                </div>
                <div class="fs-2"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= $stats['total_guru'] ?></h3>
                    <p class="mb-0">Total Guru</p>
                </div>
                <div class="fs-2"><i class="fas fa-chalkboard-teacher"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= $stats['total_murid'] ?></h3>
                    <p class="mb-0">Total Murid</p>
                </div>
                <div class="fs-2"><i class="fas fa-user-graduate"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card bg-info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-1"><?= $stats['total_orangtua'] ?></h3>
                    <p class="mb-0">Total Orang Tua</p>
                </div>
                <div class="fs-2"><i class="fas fa-user-friends"></i></div>
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
                        <h4 class="text-primary"><?= $stats['counseling_requests'] ?></h4>
                        <p class="mb-0">Total Konseling</p>
                    </div>
                    <div class="text-primary fs-3"><i class="fas fa-comments"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-warning"><?= $stats['pending_requests'] ?></h4>
                        <p class="mb-0">Menunggu Persetujuan</p>
                    </div>
                    <div class="text-warning fs-3"><i class="fas fa-clock"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="text-success"><?= $stats['active_users'] ?></h4>
                        <p class="mb-0">Pengguna Aktif</p>
                    </div>
                    <div class="text-success fs-3"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Aktivitas Terkini
                </h5>
            </div>
            <div class="card-body">
                <?php foreach ($recent_activities as $activity): ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="activity-icon me-3">
                        <?php if ($activity['type'] == 'user'): ?>
                            <i class="fas fa-user-plus text-primary"></i>
                        <?php elseif ($activity['type'] == 'counseling'): ?>
                            <i class="fas fa-comments text-warning"></i>
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1"><?= esc($activity['activity']) ?></p>
                        <small class="text-muted"><?= esc($activity['time']) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- User Growth Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Pertumbuhan Pengguna
                </h5>
            </div>
            <div class="card-body">
                <canvas id="userGrowthChart" width="400" height="200"></canvas>
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
                        <a href="/users" class="btn btn-outline-primary w-100">
                            <i class="fas fa-users me-2"></i>Kelola Pengguna
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="/roles" class="btn btn-outline-success w-100">
                            <i class="fas fa-user-tag me-2"></i>Kelola Role
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="/counseling/manage" class="btn btn-outline-warning w-100">
                            <i class="fas fa-comments me-2"></i>Kelola Konseling
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="/reports" class="btn btn-outline-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>Laporan Sistem
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
// User Growth Chart
const ctx = document.getElementById('userGrowthChart').getContext('2d');
const userGrowthChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($user_growth['labels']) ?>,
        datasets: [{
            label: 'Jumlah Pengguna',
            data: <?= json_encode($user_growth['data']) ?>,
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
