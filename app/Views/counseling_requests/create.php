<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-3"><i class="fas fa-plus me-2"></i>Ajukan Permintaan Konseling</h1>
    <form method="post" action="/counseling-requests/store">
        <div class="mb-3">
            <label for="type" class="form-label">Jenis Konseling</label>
            <select name="type" id="type" class="form-select" required>
                <option value="individu">Individu</option>
                <option value="kelompok">Kelompok</option>
                <option value="klasikal">Klasikal</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="theme" class="form-label">Tema/Topik</label>
            <input type="text" name="theme" id="theme" class="form-control" placeholder="Contoh: Karir, P5, Pribadi, dll" required>
        </div>
        <div class="mb-3">
            <label for="group_name" class="form-label">Nama Kelompok (jika kelompok/klasikal)</label>
            <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Opsional">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Permintaan</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan Permintaan</button>
        <a href="/counseling-requests" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>
