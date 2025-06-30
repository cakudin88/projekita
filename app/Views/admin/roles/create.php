<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Tambah Role Baru</h1>
                <p class="text-muted mb-0">Menambahkan role baru ke dalam sistem</p>
            </div>
            <div>
                <a href="/admin/roles" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-tag me-2"></i>Form Tambah Role
                </h5>
            </div>
            <div class="card-body">
                <!-- Validation Errors -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="/admin/roles/store" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Informasi Role
                            </h6>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name') ?>" required placeholder="Contoh: Operator Sekolah">
                        <div class="form-text">
                            Nama role akan otomatis diformat menjadi lowercase dengan underscore (contoh: operator_sekolah)
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  required placeholder="Jelaskan tugas dan tanggung jawab role ini..."><?= old('description') ?></textarea>
                        <div class="form-text">Berikan deskripsi yang jelas tentang fungsi dan tanggung jawab role ini</div>
                    </div>

                    <!-- Role Examples -->
                    <div class="mb-4">
                        <div class="card bg-light">
                            <div class="card-body py-3">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-lightbulb me-2"></i>Contoh Role yang Bisa Ditambahkan
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="role-example mb-3" onclick="fillExample('Operator Sekolah', 'Mengelola data administrasi sekolah dan input data siswa/guru')">
                                            <div class="d-flex align-items-center p-2 rounded border">
                                                <i class="fas fa-desktop text-info me-3"></i>
                                                <div>
                                                    <strong>Operator Sekolah</strong>
                                                    <br><small class="text-muted">Admin data sekolah</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="role-example mb-3" onclick="fillExample('Sekretaris', 'Mengelola surat menyurat dan administrasi kantor')">
                                            <div class="d-flex align-items-center p-2 rounded border">
                                                <i class="fas fa-file-alt text-success me-3"></i>
                                                <div>
                                                    <strong>Sekretaris</strong>
                                                    <br><small class="text-muted">Administrasi kantor</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="role-example mb-3" onclick="fillExample('Bendahara', 'Mengelola keuangan sekolah dan administrasi pembayaran')">
                                            <div class="d-flex align-items-center p-2 rounded border">
                                                <i class="fas fa-calculator text-warning me-3"></i>
                                                <div>
                                                    <strong>Bendahara</strong>
                                                    <br><small class="text-muted">Keuangan sekolah</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="role-example mb-3" onclick="fillExample('Wakil Kepala Sekolah', 'Membantu kepala sekolah dalam pengelolaan akademik dan administratif')">
                                            <div class="d-flex align-items-center p-2 rounded border">
                                                <i class="fas fa-user-friends text-primary me-3"></i>
                                                <div>
                                                    <strong>Wakil Kepala Sekolah</strong>
                                                    <br><small class="text-muted">Asisten kepala sekolah</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Klik contoh di atas untuk mengisi form otomatis</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/roles" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
    .role-example {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .role-example:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .role-example .border {
        border-color: #e2e8f0 !important;
        transition: border-color 0.3s ease;
    }

    .role-example:hover .border {
        border-color: var(--primary-blue) !important;
    }
</style>

<script>
    function fillExample(name, description) {
        document.getElementById('name').value = name;
        document.getElementById('description').value = description;
        
        // Add visual feedback
        const nameField = document.getElementById('name');
        const descField = document.getElementById('description');
        
        nameField.style.backgroundColor = '#e8f5e8';
        descField.style.backgroundColor = '#e8f5e8';
        
        setTimeout(() => {
            nameField.style.backgroundColor = '';
            descField.style.backgroundColor = '';
        }, 1000);
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const description = document.getElementById('description').value.trim();
        
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

    // Auto-format name preview
    document.getElementById('name').addEventListener('input', function() {
        const value = this.value;
        const formatted = value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
        
        // Show preview
        const helpText = this.nextElementSibling;
        if (value) {
            helpText.innerHTML = `Akan diformat menjadi: <strong>${formatted}</strong>`;
        } else {
            helpText.innerHTML = 'Nama role akan otomatis diformat menjadi lowercase dengan underscore (contoh: operator_sekolah)';
        }
    });
</script>
<?= $this->endSection() ?>
