<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?= $title ?></h3>
                    <a href="/counseling-requests" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajukan Permintaan Baru
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> 
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> 
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($db_error)): ?>
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Database Belum Siap</h5>
                            <p><?= $db_error ?></p>
                        </div>
                    <?php else: ?>
                        
                        <?php if (empty($requests)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum Ada Permintaan Konseling</h4>
                                <p class="text-muted">Anda belum pernah mengajukan permintaan konseling.</p>
                                <a href="/counseling-requests" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajukan Permintaan Sekarang
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($requests as $request): ?>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 border-left-<?= 
                                            match($request['status']) {
                                                'pending' => 'warning',
                                                'approved' => 'success', 
                                                'rejected' => 'danger',
                                                'completed' => 'primary',
                                                default => 'secondary'
                                            } 
                                        ?>">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="card-title mb-0"><?= esc($request['theme']) ?></h6>
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
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <small class="text-muted">Jenis Konseling:</small>
                                                    <span class="badge bg-info"><?= ucfirst(esc($request['type'])) ?></span>
                                                </div>
                                                
                                                <?php if (!empty($request['group_name'])): ?>
                                                    <div class="mb-2">
                                                        <small class="text-muted">Nama Kelompok:</small><br>
                                                        <strong><?= esc($request['group_name']) ?></strong>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="mb-3">
                                                    <small class="text-muted">Deskripsi:</small>
                                                    <p class="mb-0"><?= esc($request['description']) ?></p>
                                                </div>

                                                <!-- Status Information -->
                                                <?php if ($request['status'] === 'approved'): ?>
                                                    <?php if (!empty($request['counseling_date'])): ?>
                                                        <div class="alert alert-success">
                                                            <h6><i class="fas fa-calendar-check"></i> Jadwal Konseling</h6>
                                                            <p class="mb-1">
                                                                <strong><?= indonesian_date($request['counseling_date'], 'full') ?></strong>
                                                            </p>
                                                            <small class="text-success">
                                                                Pukul <?= date('H:i', strtotime($request['counseling_date'])) ?> WIB
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($request['response_message'])): ?>
                                                        <div class="alert alert-info">
                                                            <h6><i class="fas fa-comment"></i> Pesan dari Guru BK</h6>
                                                            <p class="mb-0"><?= esc($request['response_message']) ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php elseif ($request['status'] === 'rejected'): ?>
                                                    <?php if (!empty($request['rejected_reason'])): ?>
                                                        <div class="alert alert-danger">
                                                            <h6><i class="fas fa-exclamation-circle"></i> Alasan Penolakan</h6>
                                                            <p class="mb-0"><?= esc($request['rejected_reason']) ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php elseif ($request['status'] === 'pending'): ?>
                                                    <div class="alert alert-warning">
                                                        <h6><i class="fas fa-clock"></i> Menunggu Persetujuan</h6>
                                                        <p class="mb-0">Permintaan Anda sedang ditinjau oleh Guru BK. Silakan tunggu konfirmasi lebih lanjut.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar"></i> 
                                                    Diajukan: <?= indonesian_date($request['created_at'] ?? 'now', 'short') ?>
                                                </small>
                                                
                                                <?php if (!empty($request['counselor_name'])): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-user-tie"></i> 
                                                        Ditangani: <?= esc($request['counselor_name']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.border-left-danger {
    border-left: 4px solid #dc3545 !important;
}
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.border-left-secondary {
    border-left: 4px solid #6c757d !important;
}
</style>

<?= $this->endSection() ?>
