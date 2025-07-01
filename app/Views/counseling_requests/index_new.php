<?= $this->extend('layouts/fast') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="fas fa-clipboard-list me-2"></i><?= $title ?>
        </h1>
        <?php if (isset($can_create) && $can_create): ?>
        <a href="/counseling-requests/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajukan Permintaan Baru
        </a>
        <?php endif; ?>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Requests Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                <?= isset($can_manage) && $can_manage ? 'Semua Permintaan Konseling' : 'Permintaan Konseling Saya' ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($requests)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Permintaan</h5>
                <p class="text-muted">
                    <?= isset($can_create) && $can_create ? 'Anda belum memiliki permintaan konseling. Klik tombol "Ajukan Permintaan Baru" untuk membuat permintaan.' : 'Belum ada permintaan konseling yang masuk.' ?>
                </p>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <?php if (isset($can_manage) && $can_manage): ?>
                            <th>Nama Siswa</th>
                            <?php endif; ?>
                            <th>Jenis</th>
                            <th>Tema/Topik</th>
                            <th>Status</th>
                            <th>Tanggal Ajukan</th>
                            <?php if (isset($can_manage) && $can_manage): ?>
                            <th>Tanggal Konseling</th>
                            <?php endif; ?>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $index => $request): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <?php if (isset($can_manage) && $can_manage): ?>
                            <td>
                                <strong><?= $request['student_name'] ?></strong><br>
                                <small class="text-muted"><?= $request['student_username'] ?></small>
                            </td>
                            <?php endif; ?>
                            <td>
                                <span class="badge bg-info"><?= ucfirst($request['type']) ?></span>
                                <?php if (!empty($request['group_name'])): ?>
                                <br><small class="text-muted"><?= $request['group_name'] ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= $request['theme'] ?></strong>
                                <br><small class="text-muted"><?= substr($request['description'], 0, 50) ?>...</small>
                            </td>
                            <td>
                                <?php
                                $statusBadge = [
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    'completed' => 'bg-info'
                                ];
                                $statusText = [
                                    'pending' => 'Menunggu',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'completed' => 'Selesai'
                                ];
                                ?>
                                <span class="badge <?= $statusBadge[$request['status']] ?? 'bg-secondary' ?>">
                                    <?= $statusText[$request['status']] ?? ucfirst($request['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($request['created_at'])) ?></td>
                            <?php if (isset($can_manage) && $can_manage): ?>
                            <td>
                                <?php if (!empty($request['counseling_date'])): ?>
                                    <?= date('d/m/Y H:i', strtotime($request['counseling_date'])) ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                            <td>
                                <?php if (isset($can_manage) && $can_manage): ?>
                                    <!-- Actions for Counselors -->
                                    <?php if ($request['status'] === 'pending'): ?>
                                    <a href="/counseling-requests/manage/<?= $request['id'] ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Kelola Permintaan">
                                        <i class="fas fa-cogs"></i>
                                    </a>
                                    <?php else: ?>
                                    <a href="/counseling-requests/manage/<?= $request['id'] ?>" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- Actions for Students -->
                                    <button class="btn btn-sm btn-outline-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal<?= $request['id'] ?>"
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail Modals for Students -->
<?php if (isset($can_create) && $can_create && !empty($requests)): ?>
<?php foreach ($requests as $request): ?>
<div class="modal fade" id="detailModal<?= $request['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Jenis Konseling</strong></td>
                                <td>: <?= ucfirst($request['type']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tema/Topik</strong></td>
                                <td>: <?= $request['theme'] ?></td>
                            </tr>
                            <?php if (!empty($request['group_name'])): ?>
                            <tr>
                                <td><strong>Nama Kelompok</strong></td>
                                <td>: <?= $request['group_name'] ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Status</strong></td>
                                <td>: 
                                    <span class="badge <?= $statusBadge[$request['status']] ?? 'bg-secondary' ?>">
                                        <?= $statusText[$request['status']] ?? ucfirst($request['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Ajukan</strong></td>
                                <td>: <?= date('d/m/Y H:i', strtotime($request['created_at'])) ?></td>
                            </tr>
                            <?php if (!empty($request['counseling_date'])): ?>
                            <tr>
                                <td><strong>Jadwal Konseling</strong></td>
                                <td>: <?= date('d/m/Y H:i', strtotime($request['counseling_date'])) ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <strong>Deskripsi Permintaan:</strong>
                    <div class="border p-3 mt-2 bg-light rounded">
                        <?= nl2br(htmlspecialchars($request['description'])) ?>
                    </div>
                </div>

                <?php if ($request['status'] === 'approved' && !empty($request['response_message'])): ?>
                <div class="mt-3">
                    <strong>Pesan dari Guru BK:</strong>
                    <div class="border p-3 mt-2 bg-success bg-opacity-10 rounded">
                        <?= nl2br(htmlspecialchars($request['response_message'])) ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($request['status'] === 'rejected' && !empty($request['rejected_reason'])): ?>
                <div class="mt-3">
                    <strong>Alasan Penolakan:</strong>
                    <div class="border p-3 mt-2 bg-danger bg-opacity-10 rounded">
                        <?= nl2br(htmlspecialchars($request['rejected_reason'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<!-- Custom CSS -->
<style>
.table-borderless td {
    padding: 0.5rem 0;
    border: none;
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 15px;
}

.card-header {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-radius: 15px 15px 0 0 !important;
}

.btn {
    border-radius: 8px;
}

.badge {
    border-radius: 8px;
}

.alert {
    border-radius: 10px;
}

.modal-content {
    border-radius: 15px;
}
</style>

<?= $this->endSection() ?>
