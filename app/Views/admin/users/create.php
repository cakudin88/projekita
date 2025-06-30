<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Tambah Pengguna Baru</h1>
                <p class="text-muted mb-0">Menambahkan pengguna baru ke dalam sistem</p>
            </div>
            <div>
                <a href="/admin/users" class="btn btn-outline-secondary">
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
                    <i class="fas fa-user-plus me-2"></i>Form Tambah Pengguna
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

                <form action="/admin/users/store" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Personal Information -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>Informasi Personal
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?= old('full_name') ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= old('username') ?>" required>
                            <div class="form-text">Username harus unik dan minimal 3 karakter</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= old('email') ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?= old('phone') ?>" placeholder="Contoh: 08123456789">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3" 
                                  placeholder="Masukkan alamat lengkap..."><?= old('address') ?></textarea>
                    </div>

                    <hr class="my-4">

                    <!-- Account Information -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-key me-2"></i>Informasi Akun
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <div class="form-text">Password minimal 6 karakter</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Pilih Role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= old('role_id') == $role['id'] ? 'selected' : '' ?>>
                                        <?= ucwords(str_replace('_', ' ', $role['name'])) ?>
                                        <?php if ($role['description']): ?>
                                            - <?= $role['description'] ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Role Description -->
                    <div class="mb-4">
                        <div class="card bg-light">
                            <div class="card-body py-3">
                                <h6 class="card-title mb-2">
                                    <i class="fas fa-info-circle me-2"></i>Deskripsi Role
                                </h6>
                                <div id="roleDescription" class="text-muted">
                                    Pilih role untuk melihat deskripsi
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/users" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pengguna
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
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Role descriptions
    const roleDescriptions = {
        <?php foreach ($roles as $role): ?>
        '<?= $role['id'] ?>': '<?= $role['description'] ?>',
        <?php endforeach; ?>
    };

    // Update role description when role is selected
    document.getElementById('role_id').addEventListener('change', function() {
        const selectedRole = this.value;
        const descriptionDiv = document.getElementById('roleDescription');
        
        if (selectedRole && roleDescriptions[selectedRole]) {
            descriptionDiv.textContent = roleDescriptions[selectedRole];
            descriptionDiv.className = 'text-dark';
        } else {
            descriptionDiv.textContent = 'Pilih role untuk melihat deskripsi';
            descriptionDiv.className = 'text-muted';
        }
    });

    // Generate username from full name
    document.getElementById('full_name').addEventListener('input', function() {
        const fullName = this.value;
        const usernameField = document.getElementById('username');
        
        // Only generate if username field is empty
        if (!usernameField.value) {
            const username = fullName.toLowerCase()
                .replace(/\s+/g, '_')
                .replace(/[^a-z0-9_]/g, '')
                .substring(0, 20);
            usernameField.value = username;
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const role = document.getElementById('role_id').value;
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter!');
            return false;
        }
        
        if (!role) {
            e.preventDefault();
            alert('Pilih role untuk pengguna!');
            return false;
        }
    });
</script>
<?= $this->endSection() ?>
