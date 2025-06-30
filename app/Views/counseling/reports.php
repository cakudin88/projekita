<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Filter & Export Row -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form class="row g-2 align-items-end" method="get" action="">
                <div class="col-auto">
                    <label for="filter_start" class="form-label mb-0">Periode:</label>
                </div>
                <div class="col-auto">
                    <input type="month" class="form-control" id="filter_start" name="start_month" value="<?= esc($_GET['start_month'] ?? '') ?>">
                </div>
                <div class="col-auto">
                    <span class="mx-1">s/d</span>
                </div>
                <div class="col-auto">
                    <input type="month" class="form-control" id="filter_end" name="end_month" value="<?= esc($_GET['end_month'] ?? '') ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary"><i class="fas fa-filter me-1"></i>Filter</button>
                </div>
                <div class="col-auto">
                    <a href="?" class="btn btn-outline-secondary"><i class="fas fa-times me-1"></i>Reset</a>
                </div>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="/counseling/export?<?= http_build_query($_GET) ?>" class="btn btn-primary me-2">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
            <a href="#" onclick="window.print();return false;" class="btn btn-outline-success me-2">
                <i class="fas fa-print me-2"></i>Cetak
            </a>
            <a href="/counseling/export-pdf?<?= http_build_query($_GET) ?>" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Laporan Bimbingan Konseling</h1>
                    <p class="text-muted mb-0">Statistik dan analisis data konseling</p>
                </div>
                <div>
                    <a href="/counseling/export" class="btn btn-primary me-2">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                    <a href="/counseling" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Error Alert -->
            <?php if (isset($error)): ?>
                <div class="alert alert-warning mb-4">
                    <strong>Peringatan:</strong> <?= $error ?>
                    <br><small>Menampilkan data contoh untuk demo.</small>
                </div>
            <?php endif; ?>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mb-1"><?= $stats['total_sessions'] ?? 0 ?></h3>
                                    <p class="mb-0">Total Sesi</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mb-1"><?= $stats['total_students'] ?? 0 ?></h3>
                                    <p class="mb-0">Total Siswa</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mb-1"><?= $stats['completed'] ?? 0 ?></h3>
                                    <p class="mb-0">Sesi Selesai</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="mb-1"><?= $stats['scheduled'] ?? 0 ?></h3>
                                    <p class="mb-0">Sesi Terjadwal</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- Status Distribution -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Distribusi Status Sesi
                            </h5>
                        </div>
                        <div class="card-body" style="height:320px;">
                            <canvas id="statusChart"></canvas>
                            <div class="mt-3">
                                <div class="row text-center">
                                    <div class="col-3">
                                        <span class="badge bg-primary"><?= $stats['scheduled'] ?? 0 ?></span>
                                        <small class="d-block text-muted">Terjadwal</small>
                                    </div>
                                    <div class="col-3">
                                        <span class="badge bg-warning"><?= $stats['ongoing'] ?? 0 ?></span>
                                        <small class="d-block text-muted">Berlangsung</small>
                                    </div>
                                    <div class="col-3">
                                        <span class="badge bg-success"><?= $stats['completed'] ?? 0 ?></span>
                                        <small class="d-block text-muted">Selesai</small>
                                    </div>
                                    <div class="col-3">
                                        <span class="badge bg-danger"><?= $stats['cancelled'] ?? 0 ?></span>
                                        <small class="d-block text-muted">Dibatalkan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Distribution -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Sesi per Kategori
                            </h5>
                        </div>
                        <div class="card-body" style="height:320px;">
                            <canvas id="categoryChart"></canvas>
                            <div class="mt-3">
                                <?php if (isset($stats['by_category'])): ?>
                                    <?php foreach ($stats['by_category'] as $category): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <span class="badge" style="background-color: <?= $category['color'] ?>">
                                                    <?= $category['name'] ?>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold"><?= $category['count'] ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-line me-2"></i>Tren Sesi Konseling Bulanan
                            </h5>
                        </div>
                        <div class="card-body" style="height:350px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Reports -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>Siswa Perlu Perhatian
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php if (isset($students_attention) && count($students_attention) > 0): ?>
                                    <?php foreach ($students_attention as $student): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="#" class="student-detail-link" data-id="<?= $student['id'] ?>">
                                                    <strong><?= esc($student['name']) ?></strong>
                                                </a>
                                                <small class="d-block text-muted"><?= esc($student['class']) ?> - <?= esc($student['session_count']) ?> sesi konseling</small>
                                            </div>
                                            <span class="badge bg-<?= $student['level'] === 'intervensi' ? 'danger' : 'warning' ?>">
                                                <?= ucfirst($student['level']) ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="list-group-item text-center text-muted">Tidak ada data siswa perhatian.</div>
                                <?php endif; ?>
                            </div>
                            <!-- Modal Detail Siswa -->
                            <div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="studentDetailModalLabel">Detail Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="studentDetailContent">
                                                <div class="text-center text-muted">Memuat data...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-trophy me-2"></i>Kategori Tersering
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($stats['by_category'])): ?>
                                <?php 
                                $sortedCategories = $stats['by_category'];
                                usort($sortedCategories, function($a, $b) {
                                    return $b['count'] - $a['count'];
                                });
                                ?>
                                <?php foreach (array_slice($sortedCategories, 0, 5) as $index => $category): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <span class="badge bg-primary rounded-pill"><?= $index + 1 ?></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <span><?= $category['name'] ?></span>
                                                <span class="fw-bold"><?= $category['count'] ?> sesi</span>
                                            </div>
                                            <div class="progress mt-1" style="height: 6px;">
                                                <?php 
                                                $maxCount = max(array_column($stats['by_category'], 'count'));
                                                $percentage = $maxCount > 0 ? ($category['count'] / $maxCount) * 100 : 0;
                                                ?>
                                                <div class="progress-bar" 
                                                     style="width: <?= $percentage ?>%; background-color: <?= $category['color'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Sesi Konseling -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-table me-2"></i>Daftar Sesi Konseling
                            </h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Guru BK</th>
                                        <th>Permintaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($sessions) && count($sessions) > 0): ?>
                                        <?php foreach ($sessions as $session): ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($session['date'])) ?></td>
                                                <td>
                                                    <a href="#" class="student-detail-link" data-id="<?= $session['student_id'] ?>">
                                                        <?= esc($session['student_name']) ?>
                                                    </a>
                                                </td>
                                                <td><?= esc($session['category']) ?></td>
                                                <td>
                                                    <?php
                                                        $status = $session['status'];
                                                        $badge = 'secondary';
                                                        if ($status === 'scheduled') $badge = 'warning';
                                                        elseif ($status === 'ongoing') $badge = 'info';
                                                        elseif ($status === 'completed') $badge = 'success';
                                                        elseif ($status === 'cancelled') $badge = 'danger';
                                                    ?>
                                                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
                                                </td>
                                                <td><?= esc($session['teacher_name']) ?></td>
                                                <td>
                                                    <span class="text-muted">-</span>
                                                </td>
                                                <td>
                                                    <a href="/counseling/records/<?= $session['id'] ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data sesi konseling.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js & Modal JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [
                    <?= $stats['scheduled'] ?? 0 ?>,
                    <?= $stats['ongoing'] ?? 0 ?>,
                    <?= $stats['completed'] ?? 0 ?>,
                    <?= $stats['cancelled'] ?? 0 ?>
                ],
                backgroundColor: ['#0d6efd', '#ffc107', '#198754', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: [
                <?php if (isset($stats['by_category'])): ?>
                    <?php foreach ($stats['by_category'] as $category): ?>
                        '<?= $category['name'] ?>',
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            datasets: [{
                label: 'Jumlah Sesi',
                data: [
                    <?php if (isset($stats['by_category'])): ?>
                        <?php foreach ($stats['by_category'] as $category): ?>
                            <?= $category['count'] ?>,
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
                backgroundColor: [
                    <?php if (isset($stats['by_category'])): ?>
                        <?php foreach ($stats['by_category'] as $category): ?>
                            '<?= $category['color'] ?>',
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: [
                <?php if (isset($stats['monthly'])): ?>
                    <?php foreach ($stats['monthly'] as $month): ?>
                        '<?= $month['month'] ?>',
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            datasets: [{
                label: 'Jumlah Sesi',
                data: [
                    <?php if (isset($stats['monthly'])): ?>
                        <?php foreach ($stats['monthly'] as $month): ?>
                            <?= $month['count'] ?>,
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Modal detail siswa (AJAX)
    document.querySelectorAll('.student-detail-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const studentId = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('studentDetailModal'));
            const content = document.getElementById('studentDetailContent');
            content.innerHTML = '<div class="text-center text-muted">Memuat data...</div>';
            fetch(`/students/detail/${studentId}`)
                .then(res => res.text())
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(() => {
                    content.innerHTML = '<div class="alert alert-danger">Gagal memuat detail siswa.</div>';
                });
            modal.show();
        });
    });
});
</script>

<?= $this->endSection() ?>
