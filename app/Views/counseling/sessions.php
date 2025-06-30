<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Sesi Konseling</h1>
                    <p class="text-muted mb-0">Daftar semua sesi konseling siswa</p>
                </div>
                <div>
                    <a href="/counseling/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Sesi Baru
                    </a>
                    <a href="/counseling" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Filter dan Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option value="">Semua Status</option>
                                <option value="scheduled">Terjadwal</option>
                                <option value="ongoing">Berlangsung</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="akademik">Akademik</option>
                                <option value="sosial">Sosial</option>
                                <option value="pribadi">Pribadi</option>
                                <option value="keluarga">Keluarga</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pencarian</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari nama siswa...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Sesi Konseling -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Sesi Konseling</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($sessions) && is_array($sessions) && count($sessions) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kategori</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Mendesak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sessions as $index => $session): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($session['session_date'] ?? 'now')) ?>
                                    </td>
                                    <td>
                                        <strong><?= $session['student_name'] ?? 'Nama tidak tersedia' ?></strong>
                                        <br><small class="text-muted"><?= $session['student_class'] ?? 'Kelas tidak tersedia' ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= $session['category_name'] ?? 'N/A' ?>
                                        </span>
                                    </td>
                                    <td><?= $session['title'] ?? 'Tidak ada judul' ?></td>
                                    <td>
                                        <?php
                                        $status = $session['status'] ?? 'scheduled';
                                        $statusClass = match($status) {
                                            'scheduled' => 'bg-info',
                                            'ongoing' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                        $statusText = match($status) {
                                            'scheduled' => 'Terjadwal',
                                            'ongoing' => 'Berlangsung',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            default => 'Unknown'
                                        };
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                    <td>
                                        <?php if (isset($session['is_urgent']) && $session['is_urgent']): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-exclamation-triangle"></i> Mendesak
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada sesi konseling</h5>
                        <p class="text-muted">Mulai dengan membuat sesi konseling baru untuk siswa</p>
                        <a href="/counseling/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Sesi Pertama
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pagination (jika diperlukan) -->
            <?php if (isset($sessions) && count($sessions) > 10): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
