<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-3"><i class="fas fa-calendar-alt me-2"></i>Jadwal Konseling</h1>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Guru BK</th>
                            <th>Tanggal</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)): ?>
                            <?php $no = 1; foreach ($appointments as $a): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($a['student_name']) ?></td>
                                    <td><?= esc($a['guru_name']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($a['appointment_date'])) ?></td>
                                    <td><?= esc($a['purpose']) ?></td>
                                    <td><span class="badge bg-<?= $a['status'] == 'approved' ? 'success' : ($a['status'] == 'pending' ? 'warning' : ($a['status'] == 'completed' ? 'primary' : 'secondary')) ?>"><?= esc(ucfirst($a['status'])) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted">Belum ada jadwal konseling.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
