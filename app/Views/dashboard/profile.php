<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Profile Pengguna</h1>
                <p class="text-muted mb-0">Kelola informasi akun dan pengaturan profile Anda</p>
            </div>
            <div>
                <a href="/dashboard" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Info -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar-large mx-auto mb-3">
                    <?php if ($user['avatar']): ?>
                        <img src="/uploads/avatars/<?= $user['avatar'] ?>" alt="Avatar" class="avatar-img">
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <?= strtoupper(substr($user['full_name'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h4 class="card-title mb-1"><?= $user['full_name'] ?></h4>
                <p class="text-muted mb-3"><?= ucwords(str_replace('_', ' ', $user['role_name'])) ?></p>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                        <i class="fas fa-camera me-2"></i>Ubah Foto
                    </button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-2"></i>Ubah Password
                    </button>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Status Akun</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Status</span>
                    <span class="badge bg-success">Aktif</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Role</span>
                    <span class="badge bg-primary"><?= ucwords(str_replace('_', ' ', $user['role_name'])) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Bergabung</span>
                    <small class="text-muted">
                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Personal
                </h5>
            </div>
            <div class="card-body">
                <form action="/profile/update" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?= $user['full_name'] ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= $user['username'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= $user['email'] ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?= $user['phone'] ?>" placeholder="Contoh: 08123456789">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3" 
                                  placeholder="Masukkan alamat lengkap..."><?= $user['address'] ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" value="<?= $user['role_description'] ?>" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" value="Aktif" readonly disabled>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Aktivitas Terakhir
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Login Berhasil</h6>
                            <p class="timeline-text text-muted mb-1">
                                Login berhasil dari alamat IP: <?= $_SERVER['REMOTE_ADDR'] ?? 'Unknown' ?>
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?= date('d M Y, H:i') ?> WIB
                            </small>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Akun Dibuat</h6>
                            <p class="timeline-text text-muted mb-1">
                                Akun berhasil didaftarkan dalam sistem
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?= date('d M Y, H:i', strtotime($user['created_at'])) ?> WIB
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Avatar Modal -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/profile/upload-avatar" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="text-center mb-3">
                        <div class="avatar-preview" id="avatarPreview">
                            <?php if ($user['avatar']): ?>
                                <img src="/uploads/avatars/<?= $user['avatar'] ?>" alt="Avatar" class="avatar-img">
                            <?php else: ?>
                                <div class="avatar-placeholder">
                                    <?= strtoupper(substr($user['full_name'], 0, 2)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" 
                               accept="image/*" onchange="previewAvatar(this)">
                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/profile/change-password" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" 
                               name="current_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" 
                               name="new_password" required minlength="6">
                        <div class="form-text">Minimal 6 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirm_password" 
                               name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .avatar-large {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        position: relative;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 600;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .avatar-preview {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }

    .avatar-preview .avatar-img,
    .avatar-preview .avatar-placeholder {
        width: 100%;
        height: 100%;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .avatar-preview .avatar-placeholder {
        font-size: 1.2rem;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .timeline-content {
        padding-left: 15px;
    }

    .timeline-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #1e293b;
    }

    .timeline-text {
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 5px;
    }
</style>

<script>
    function resetForm() {
        document.querySelector('form').reset();
    }

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-img">`;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Password confirmation validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = this.value;
        
        if (newPassword !== confirmPassword) {
            this.setCustomValidity('Password tidak sama');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<?= $this->endSection() ?>
