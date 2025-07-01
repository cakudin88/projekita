<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus me-2"></i>
                        <?= $title ?? 'Ajukan Permintaan Konseling' ?>
                    </h3>
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

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> Ada kesalahan dalam form:</h6>
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/counseling-requests/store">
                        <div class="mb-3">
                            <label for="type" class="form-label">
                                <i class="fas fa-users"></i> Jenis Konseling *
                            </label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">-- Pilih Jenis Konseling --</option>
                                <option value="individu" <?= old('type') === 'individu' ? 'selected' : '' ?>>
                                    Individu (Personal/Pribadi)
                                </option>
                                <option value="kelompok" <?= old('type') === 'kelompok' ? 'selected' : '' ?>>
                                    Kelompok (2-8 orang)
                                </option>
                                <option value="klasikal" <?= old('type') === 'klasikal' ? 'selected' : '' ?>>
                                    Klasikal (Satu kelas)
                                </option>
                            </select>
                            <div class="form-text">Pilih jenis konseling sesuai kebutuhan Anda</div>
                        </div>

                        <div class="mb-3">
                            <label for="theme" class="form-label">
                                <i class="fas fa-tag"></i> Tema/Topik Konseling *
                            </label>
                            <input type="text" name="theme" id="theme" class="form-control" 
                                   placeholder="Contoh: Masalah Akademik, Karir, Pribadi, Sosial" 
                                   value="<?= old('theme') ?>" required>
                            <div class="form-text">Berikan tema yang spesifik untuk membantu proses konseling</div>
                        </div>

                        <div class="mb-3" id="group_name_div" style="display: none;">
                            <label for="group_name" class="form-label">
                                <i class="fas fa-users"></i> Nama Kelompok/Kelas
                            </label>
                            <input type="text" name="group_name" id="group_name" class="form-control" 
                                   placeholder="Contoh: Kelompok Belajar A, Kelas XII IPA 1"
                                   value="<?= old('group_name') ?>">
                            <div class="form-text">Sebutkan nama kelompok atau kelas yang akan mengikuti konseling</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-file-alt"></i> Deskripsi Permintaan *
                            </label>
                            <textarea name="description" id="description" class="form-control" rows="5" 
                                      placeholder="Jelaskan secara detail masalah atau topik yang ingin didiskusikan dalam konseling..." 
                                      required><?= old('description') ?></textarea>
                            <div class="form-text">Berikan penjelasan yang detail untuk membantu Guru BK memahami kebutuhan Anda</div>
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
                            <ul class="mb-0">
                                <li>Permintaan akan ditinjau oleh Guru BK dalam 1-2 hari kerja</li>
                                <li>Anda akan mendapat notifikasi jika permintaan disetujui atau ditolak</li>
                                <li>Pastikan deskripsi yang Anda berikan jelas dan lengkap</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/counseling-requests/status" class="btn btn-secondary">
                                <i class="fas fa-eye"></i> Lihat Status
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Ajukan Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const groupDiv = document.getElementById('group_name_div');
    const groupInput = document.getElementById('group_name');
    
    if (this.value === 'kelompok' || this.value === 'klasikal') {
        groupDiv.style.display = 'block';
        groupInput.required = true;
    } else {
        groupDiv.style.display = 'none';
        groupInput.required = false;
        groupInput.value = '';
    }
});

// Trigger pada page load jika ada old input
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    if (typeSelect.value) {
        typeSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<?= $this->endSection() ?>
