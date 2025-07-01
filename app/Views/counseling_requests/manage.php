<?= $this->extend('layouts/fast') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>Kelola Permintaan Konseling
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Detail Permintaan -->
                    <div class="mb-4">
                        <h5><i class="fas fa-info-circle me-2"></i>Detail Permintaan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Nama Siswa</strong></td>
                                        <td>: <?= $request['student_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username</strong></td>
                                        <td>: <?= $request['student_username'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: <?= $request['student_email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Konseling</strong></td>
                                        <td>: <?= ucfirst($request['type']) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Tema/Topik</strong></td>
                                        <td>: <?= $request['theme'] ?></td>
                                    </tr>
                                    <?php if (!empty($request['group_name'])): ?>
                                    <tr>
                                        <td><strong>Nama Kelompok</strong></td>
                                        <td>: <?= $request['group_name'] ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>: 
                                            <?php
                                            $statusBadge = [
                                                'pending' => 'bg-warning',
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
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Ajukan</strong></td>
                                        <td>: <?= date('d/m/Y H:i', strtotime($request['created_at'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <strong>Deskripsi Permintaan:</strong>
                            <div class="border p-3 mt-2 bg-light rounded">
                                <?= nl2br(htmlspecialchars($request['description'])) ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($request['status'] === 'pending'): ?>
                    <!-- Form Approve/Reject -->
                    <div class="row">
                        <!-- Form Setujui -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-check me-2"></i>Setujui Permintaan</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="/counseling-requests/approve/<?= $request['id'] ?>">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label for="counseling_date" class="form-label">Tanggal & Waktu Konseling *</label>
                                            <input type="datetime-local" 
                                                   name="counseling_date" 
                                                   id="counseling_date" 
                                                   class="form-control" 
                                                   min="<?= date('Y-m-d\TH:i') ?>"
                                                   required>
                                            <small class="text-muted">Pilih tanggal dan waktu untuk melakukan konseling</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="response_message" class="form-label">Pesan/Catatan (Opsional)</label>
                                            <textarea name="response_message" 
                                                      id="response_message" 
                                                      class="form-control" 
                                                      rows="3" 
                                                      placeholder="Pesan untuk siswa, persiapan yang diperlukan, dll..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-check me-2"></i>Setujui & Jadwalkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Form Tolak -->
                        <div class="col-md-6">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h6 class="mb-0"><i class="fas fa-times me-2"></i>Tolak Permintaan</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="/counseling-requests/reject/<?= $request['id'] ?>">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label for="rejected_reason" class="form-label">Alasan Penolakan *</label>
                                            <textarea name="rejected_reason" 
                                                      id="rejected_reason" 
                                                      class="form-control" 
                                                      rows="5" 
                                                      placeholder="Jelaskan alasan mengapa permintaan ditolak..."
                                                      required></textarea>
                                            <small class="text-muted">Berikan alasan yang jelas untuk siswa</small>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-times me-2"></i>Tolak Permintaan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php elseif ($request['status'] === 'approved'): ?>
                    <!-- Show Approval Details -->
                    <div class="alert alert-success">
                        <h6><i class="fas fa-check-circle me-2"></i>Permintaan Telah Disetujui</h6>
                        <p><strong>Dijadwalkan pada:</strong> <?= date('d/m/Y H:i', strtotime($request['counseling_date'])) ?></p>
                        <?php if (!empty($request['response_message'])): ?>
                        <p><strong>Pesan:</strong> <?= nl2br(htmlspecialchars($request['response_message'])) ?></p>
                        <?php endif; ?>
                        <p><strong>Disetujui oleh:</strong> <?= $request['counselor_name'] ?? 'Guru BK' ?></p>
                    </div>
                    <?php elseif ($request['status'] === 'rejected'): ?>
                    <!-- Show Rejection Details -->
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-times-circle me-2"></i>Permintaan Telah Ditolak</h6>
                        <p><strong>Alasan penolakan:</strong></p>
                        <div class="border p-2 bg-light rounded">
                            <?= nl2br(htmlspecialchars($request['rejected_reason'])) ?>
                        </div>
                        <p class="mt-2 mb-0"><strong>Ditolak oleh:</strong> <?= $request['counselor_name'] ?? 'Guru BK' ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="/counseling-requests" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Permintaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
.table-borderless td {
    padding: 0.5rem 0;
    border: none;
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.btn {
    border-radius: 8px;
}

.alert {
    border-radius: 10px;
}
</style>

<?= $this->endSection() ?>
