<?= $this->extend('layouts/fast') ?>

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

            <!-- Content -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Daftar Sesi Konseling
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <strong>Error:</strong> <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($sessions)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada sesi konseling</h5>
                            <p class="text-muted">Klik tombol "Sesi Baru" untuk membuat sesi konseling pertama.</p>
                            <a href="/counseling/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Sesi Baru
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sessions as $session): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($session['session_date'])) ?></td>
                                            <td><?= $session['student_name'] ?></td>
                                            <td>
                                                <span class="badge bg-light text-dark"><?= $session['student_class'] ?? 'N/A' ?></span>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: <?= $session['category_color'] ?? '#007bff' ?>">
                                                    <?= $session['category_name'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = match($session['status']) {
                                                    'scheduled' => 'bg-primary',
                                                    'ongoing' => 'bg-warning',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                                
                                                $statusText = match($session['status']) {
                                                    'scheduled' => 'Terjadwal',
                                                    'ongoing' => 'Berlangsung',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Dibatalkan',
                                                    default => ucfirst($session['status'])
                                                };
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= $session['description'] ?>">
                                                    <?= $session['description'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/counseling/edit/<?= $session['id'] ?>" class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="deleteSesi(<?= $session['id'] ?>)" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
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
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus sesi konseling ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
let sessionToDelete = null;

function deleteSesi(id) {
    sessionToDelete = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (sessionToDelete) {
        fetch(`/counseling/delete/${sessionToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        modal.hide();
    }
});
</script>

<?= $this->endSection() ?>
