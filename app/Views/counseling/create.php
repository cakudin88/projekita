<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Buat Sesi Konseling Baru</h1>
                    <p class="text-muted mb-0">Isi form di bawah untuk membuat sesi konseling baru</p>
                </div>
                <div>
                    <a href="/counseling/sessions" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Sesi
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <!-- Form Sesi Konseling -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Sesi Konseling</h5>
                        </div>
                        <div class="card-body">
                            <form action="/counseling/store" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="student_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                                        <select class="form-select" id="student_id" name="student_id" required>
                                            <option value="">Pilih Siswa</option>
                                            <?php if (isset($students) && is_array($students)): ?>
                                                <?php foreach ($students as $student): ?>
                                                <option value="<?= $student['id'] ?>">
                                                    <?= $student['name'] ?? 'Nama tidak tersedia' ?> - 
                                                    <?= $student['class'] ?? 'Kelas tidak tersedia' ?>
                                                </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="1">Andi Pratama - 7A</option>
                                                <option value="2">Siti Nurhaliza - 7B</option>
                                                <option value="3">Budi Santoso - 8A</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            <?php if (isset($categories) && is_array($categories)): ?>
                                                <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>">
                                                    <?= $category['name'] ?? 'Unknown' ?> (<?= $category['code'] ?? 'N/A' ?>)
                                                </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="1">Akademik (AKD)</option>
                                                <option value="2">Sosial (SOC)</option>
                                                <option value="3">Pribadi (PER)</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Sesi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           placeholder="Contoh: Konsultasi Akademik - Kesulitan Matematika" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" 
                                              placeholder="Jelaskan permasalahan yang akan dibahas dalam sesi konseling..." required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="session_date" class="form-label">Tanggal & Waktu <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="session_date" name="session_date" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="scheduled">Terjadwal</option>
                                            <option value="ongoing">Berlangsung</option>
                                            <option value="completed">Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_urgent" name="is_urgent" value="1">
                                        <label class="form-check-label" for="is_urgent">
                                            <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                            Tandai sebagai sesi mendesak
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="/counseling/sessions" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Sesi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Panduan -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Panduan Pengisian</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-primary">Tips Judul Sesi:</h6>
                                <ul class="small">
                                    <li>Gunakan judul yang jelas dan spesifik</li>
                                    <li>Sertakan kategori masalah</li>
                                    <li>Contoh: "Konseling Akademik - Motivasi Belajar"</li>
                                </ul>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-success">Kategori Konseling:</h6>
                                <ul class="small">
                                    <li><strong>Akademik:</strong> Prestasi, motivasi belajar</li>
                                    <li><strong>Sosial:</strong> Interaksi, pertemanan</li>
                                    <li><strong>Pribadi:</strong> Kepribadian, emosi</li>
                                    <li><strong>Keluarga:</strong> Hubungan keluarga</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Sesi yang ditandai mendesak akan mendapat prioritas dalam jadwal konseling.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-select student if student_id is in query string
    const urlParams = new URLSearchParams(window.location.search);
    const studentId = urlParams.get('student_id');
    if (studentId) {
        const select = document.getElementById('student_id');
        if (select) {
            select.value = studentId;
        }
    }
});
</script>

<?= $this->endSection() ?>
