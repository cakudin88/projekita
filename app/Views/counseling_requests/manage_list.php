<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $title ?></h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($db_error)): ?>
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Database Belum Siap</h5>
                            <p><?= $db_error ?></p>
                            <p>Silakan import file SQL terlebih dahulu untuk menggunakan fitur ini.</p>
                        </div>
                    <?php else: ?>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Murid</th>
                                        <th>Jenis</th>
                                        <th>Tema</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($requests)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                                Belum ada permintaan konseling
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($requests as $index => $request): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <strong><?= esc($request['student_name'] ?? 'Murid #' . $request['student_id']) ?></strong><br>
                                                    <small class="text-muted"><?= esc($request['student_username'] ?? '') ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= ucfirst(esc($request['type'])) ?></span>
                                                    <?php if (!empty($request['group_name'])): ?>
                                                        <br><small class="text-muted"><?= esc($request['group_name']) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($request['theme']) ?></td>
                                                <td>
                                                    <div style="max-width: 200px;">
                                                        <?= substr(esc($request['description']), 0, 100) ?>
                                                        <?php if (strlen($request['description']) > 100): ?>...<?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusClass = match($request['status']) {
                                                        'pending' => 'warning',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                        'completed' => 'primary',
                                                        default => 'secondary'
                                                    };
                                                    $statusText = match($request['status']) {
                                                        'pending' => 'Menunggu',
                                                        'approved' => 'Disetujui',
                                                        'rejected' => 'Ditolak',
                                                        'completed' => 'Selesai',
                                                        default => ucfirst($request['status'])
                                                    };
                                                    ?>
                                                    <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                                    
                                                    <?php if ($request['status'] === 'approved' && !empty($request['counseling_date'])): ?>
                                                        <br><small class="text-success">
                                                            <i class="fas fa-calendar"></i> 
                                                            <?= date('d/m/Y H:i', strtotime($request['counseling_date'])) ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= date('d/m/Y', strtotime($request['created_at'] ?? $request['id'])) ?>
                                                </td>
                                                <td>
                                                    <?php if ($request['status'] === 'pending'): ?>
                                                        <div class="btn-group-vertical gap-1">
                                                            <button class="btn btn-success btn-sm" onclick="approveRequest(<?= $request['id'] ?>, '<?= esc($request['theme']) ?>')">
                                                                <i class="fas fa-check"></i> Setujui
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="rejectRequest(<?= $request['id'] ?>, '<?= esc($request['theme']) ?>')">
                                                                <i class="fas fa-times"></i> Tolak
                                                            </button>
                                                        </div>
                                                    <?php else: ?>
                                                        <button class="btn btn-info btn-sm" onclick="viewDetails(<?= $request['id'] ?>)">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Approve -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setujui Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                <div class="modal-body">
                    <p><strong>Tema:</strong> <span id="approveTheme"></span></p>
                    <div class="mb-3">
                        <label for="counseling_date" class="form-label">Tanggal & Waktu Konseling *</label>
                        <input type="datetime-local" class="form-control" id="counseling_date" name="counseling_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="response_message" class="form-label">Pesan untuk Murid</label>
                        <textarea class="form-control" id="response_message" name="response_message" rows="3" 
                                placeholder="Pesan tambahan atau instruksi untuk murid..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui Konseling</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                <div class="modal-body">
                    <p><strong>Tema:</strong> <span id="rejectTheme"></span></p>
                    <div class="mb-3">
                        <label for="rejected_reason" class="form-label">Alasan Penolakan *</label>
                        <textarea class="form-control" id="rejected_reason" name="rejected_reason" rows="4" 
                                placeholder="Jelaskan alasan penolakan kepada murid..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveRequest(id, theme) {
    document.getElementById('approveTheme').textContent = theme;
    document.getElementById('approveForm').action = '/counseling-requests/approve/' + id;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectRequest(id, theme) {
    document.getElementById('rejectTheme').textContent = theme;
    document.getElementById('rejectForm').action = '/counseling-requests/reject/' + id;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function viewDetails(id) {
    window.location.href = '/counseling-requests/manage/' + id;
}
</script>

<?= $this->endSection() ?>
