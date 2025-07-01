<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Edit Sesi Konseling</h1>
                    <p class="text-muted mb-0">Edit data sesi konseling</p>
                </div>
                <div>
                    <a href="/counseling/sessions" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit me-2"></i>Form Edit Sesi Konseling
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <form action="/counseling/update/<?= $session['id'] ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="student_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                                            <select class="form-select" id="student_id" name="student_id" required>
                                                <option value="">Pilih Siswa</option>
                                                <?php foreach ($students as $student): ?>
                                                    <option value="<?= $student['id'] ?>" 
                                                            <?= $student['id'] == $session['student_id'] ? 'selected' : '' ?>>
                                                        <?= $student['name'] ?> - <?= $student['class'] ?> (<?= $student['nis'] ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category['id'] ?>" 
                                                            <?= $category['id'] == $session['category_id'] ? 'selected' : '' ?>>
                                                        <?= $category['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="session_date" class="form-label">Tanggal Sesi <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="session_date" name="session_date" 
                                                   value="<?= $session['session_date'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="session_time" class="form-label">Waktu Sesi</label>
                                            <input type="time" class="form-control" id="session_time" name="session_time" 
                                                   value="<?= $session['session_time'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="priority" class="form-label">Prioritas</label>
                                            <select class="form-select" id="priority" name="priority">
                                                <option value="normal" <?= ($session['priority'] ?? 'normal') == 'normal' ? 'selected' : '' ?>>Normal</option>
                                                <option value="high" <?= ($session['priority'] ?? '') == 'high' ? 'selected' : '' ?>>Tinggi</option>
                                                <option value="urgent" <?= ($session['priority'] ?? '') == 'urgent' ? 'selected' : '' ?>>Mendesak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="scheduled" <?= $session['status'] == 'scheduled' ? 'selected' : '' ?>>Terjadwal</option>
                                                <option value="ongoing" <?= $session['status'] == 'ongoing' ? 'selected' : '' ?>>Berlangsung</option>
                                                <option value="completed" <?= $session['status'] == 'completed' ? 'selected' : '' ?>>Selesai</option>
                                                <option value="cancelled" <?= $session['status'] == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" 
                                              placeholder="Jelaskan masalah atau topik yang akan dibahas dalam sesi konseling..." required><?= $session['description'] ?></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/counseling/sessions" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Sesi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
