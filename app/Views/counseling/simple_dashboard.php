<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bimbingan Konseling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        .stats-card {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
        }
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="p-4">
                    <h1 class="h3 mb-1">Dashboard Bimbingan Konseling</h1>
                    <p class="text-muted mb-4">SMP Negeri 1 Pasuruan - Sistem Bimbingan dan Konseling</p>
                    
                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="stats-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-number"><?= $stats['total_sessions'] ?? 0 ?></div>
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
                                        <div class="stats-number"><?= $stats['total_students'] ?? 0 ?></div>
                                        <div class="stats-label">Total Siswa</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-users fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-number"><?= $stats['pending_sessions'] ?? 0 ?></div>
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
                                        <div class="stats-number"><?= $stats['urgent_sessions'] ?? 0 ?></div>
                                        <div class="stats-label">Mendesak</div>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Kategori Konseling</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (isset($categories) && is_array($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                            <div class="col-md-3 mb-3">
                                                <div class="border rounded p-3 text-center">
                                                    <div class="badge mb-2" style="background-color: <?= $category['color'] ?? '#6c757d' ?>">
                                                        <?= $category['code'] ?? 'N/A' ?>
                                                    </div>
                                                    <h6><?= $category['name'] ?? 'Unknown' ?></h6>
                                                    <small class="text-muted"><?= $category['description'] ?? '' ?></small>
                                                </div>
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
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Aksi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <a href="/counseling/create" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Sesi Baru
                                        </a>
                                        <a href="/counseling/sessions" class="btn btn-outline-primary">
                                            <i class="fas fa-list me-2"></i>Lihat Semua Sesi
                                        </a>
                                        <a href="#" class="btn btn-outline-success">
                                            <i class="fas fa-chart-bar me-2"></i>Laporan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
