<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Edit Role</h1>
                <p class="text-muted mb-0">Mengubah informasi role sistem</p>
            </div>
            <div>
                <a href="/admin/roles" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-10 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>Form Edit Role
                </h5>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/admin/roles/update/<?= $role['id'] ?>" method="post" id="editRoleForm">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nama Role <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?= isset(session()->getFlashdata('errors')['name']) ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= old('name', ucwords(str_replace('_', ' ', $role['name']))) ?>" 
                                       placeholder="Masukkan nama role"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Nama role akan dikonversi menjadi format sistem (lowercase dengan underscore)
                                </div>
                                <?php if (isset(session()->getFlashdata('errors')['name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Preview Nama Role</label>
                                <div class="form-control bg-light" id="namePreview">
                                    <?= $role['name'] ?>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-eye me-1"></i>
                                    Begini nama role akan tersimpan di database
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control <?= isset(session()->getFlashdata('errors')['description']) ? 'is-invalid' : '' ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Masukkan deskripsi role"
                                  required><?= old('description', $role['description']) ?></textarea>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Berikan deskripsi yang jelas tentang fungsi dan tanggung jawab role ini
                        </div>
                        <?php if (isset(session()->getFlashdata('errors')['description'])): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['description'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Role Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        Informasi Role
                                    </h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">ID Role:</small>
                                            <div class="fw-bold"><?= $role['id'] ?></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Dibuat:</small>
                                            <div class="fw-bold"><?= date('d M Y', strtotime($role['created_at'])) ?></div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <small class="text-muted">Nama Saat Ini:</small>
                                            <div class="fw-bold"><?= $role['name'] ?></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Diupdate:</small>
                                            <div class="fw-bold"><?= date('d M Y', strtotime($role['updated_at'])) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Peringatan
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Mengubah nama role dapat mempengaruhi sistem</li>
                                        <li>Pastikan nama role sesuai dengan konvensi</li>
                                        <li>Role yang sudah digunakan tidak disarankan diubah</li>
                                        <li>Perubahan akan langsung berlaku untuk semua pengguna</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/roles" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-generate preview nama role
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value.toLowerCase().replace(/\s+/g, '_');
        document.getElementById('namePreview').textContent = name || '(nama_role)';
    });

    // Form validation
    document.getElementById('editRoleForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const description = document.getElementById('description').value.trim();
        
        if (!name || !description) {
            e.preventDefault();
            alert('Semua field wajib diisi!');
            return false;
        }
        
        if (name.length < 3) {
            e.preventDefault();
            alert('Nama role minimal 3 karakter!');
            return false;
        }
        
        if (description.length < 5) {
            e.preventDefault();
            alert('Deskripsi minimal 5 karakter!');
            return false;
        }
    });
</script>
<?= $this->endSection() ?>
