<?= $this->extend('layouts/fast') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Role Tidak Dikenali
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="py-5">
                        <i class="fas fa-user-times fa-5x text-gray-400 mb-4"></i>
                        <h4 class="text-gray-600">Maaf, Role Anda Tidak Dikenali</h4>
                        <p class="text-muted mb-4">
                            <?= isset($message) ? esc($message) : 'Role Anda tidak memiliki dashboard yang sesuai. Silakan hubungi administrator untuk mendapatkan akses yang tepat.' ?>
                        </p>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <strong>Role Anda:</strong> <?= esc(session()->get('role_name') ?? 'Tidak diketahui') ?>
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Username:</strong> <?= esc(session()->get('username') ?? 'Tidak diketahui') ?>
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Nama Lengkap:</strong> <?= esc(session()->get('full_name') ?? 'Tidak diketahui') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="/profile" class="btn btn-primary me-2">
                                <i class="fas fa-user me-1"></i>Lihat Profil
                            </a>
                            <a href="/logout" class="btn btn-secondary">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kontak -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Bantuan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Hubungi Administrator</h6>
                            <p class="text-muted">
                                Jika Anda merasa role Anda salah atau memerlukan akses khusus, 
                                silakan hubungi administrator sistem dengan informasi berikut:
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-user text-primary me-2"></i><strong>User ID:</strong> <?= esc(session()->get('user_id') ?? 'Tidak diketahui') ?></li>
                                <li><i class="fas fa-envelope text-primary me-2"></i><strong>Email:</strong> admin@sekolah.sch.id</li>
                                <li><i class="fas fa-phone text-primary me-2"></i><strong>Telepon:</strong> (021) 1234-5678</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Role yang Tersedia</h6>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Super Admin
                                    <span class="badge badge-primary">Akses Penuh</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Guru BK
                                    <span class="badge badge-success">Konseling</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Guru Mapel
                                    <span class="badge badge-info">Pembelajaran</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Wali Kelas
                                    <span class="badge badge-warning">Pembinaan</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Orang Tua
                                    <span class="badge badge-secondary">Monitoring</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    Murid
                                    <span class="badge badge-primary">Pembelajaran</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
