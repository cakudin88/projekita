<?= $this->extend('layouts/fast') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-3"><i class="fas fa-calendar-plus me-2"></i>Permintaan Konseling</h1>
    
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
    
    <?php if (isset($error)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= esc($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <a href="/counseling-requests/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Ajukan Permintaan</a>
    
    <div class="card">
        <div class="card-body p-0">
            <?php if (!empty($requests)): ?>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Jenis</th>
                            <th>Tema</th>
                            <th>Status</th>
                            <th>Waktu Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($requests as $req): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($req['student_name']) ?></td>
                                <td><?= esc(ucfirst($req['type'])) ?></td>
                                <td><?= esc($req['theme']) ?></td>
                                <td><span class="badge bg-<?= $req['status'] == 'pending' ? 'warning' : ($req['status'] == 'approved' ? 'success' : 'secondary') ?>"><?= esc(ucfirst($req['status'])) ?></span></td>
                                <td><?= date('d/m/Y H:i', strtotime($req['requested_at'])) ?></td>
                                <td>
                                    <?php if ($req['status'] == 'pending' && session('role') === 'gurubk'): ?>
                                        <form action="/counseling-requests/approve/<?= $req['id'] ?>" method="post" style="display:inline-block">
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve permintaan ini?')"><i class="fas fa-check"></i> Approve</button>
                                        </form>
                                        <form action="/counseling-requests/decline/<?= $req['id'] ?>" method="post" style="display:inline-block">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak permintaan ini?')"><i class="fas fa-times"></i> Decline</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada permintaan konseling</h5>
                    <p class="text-muted">Mulai dengan mengajukan permintaan konseling baru</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
