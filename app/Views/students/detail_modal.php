<?php if (!isset($student)) : ?>
    <div class="alert alert-danger">Data siswa tidak ditemukan.</div>
<?php else: ?>
    <div class="mb-2">
        <strong>Nama:</strong> <?= esc($student['name']) ?><br>
        <strong>NIS:</strong> <?= esc($student['nis'] ?? '-') ?><br>
        <strong>Kelas:</strong> <?= esc($student['class'] ?? '-') ?><br>
        <strong>Email:</strong> <?= esc($student['email'] ?? '-') ?><br>
        <strong>Telepon:</strong> <?= esc($student['phone'] ?? '-') ?><br>
        <strong>Username:</strong> <?= esc($student['username'] ?? '-') ?><br>
    </div>
    <div class="mb-2">
        <strong>Dibuat:</strong> <?= date('d-m-Y H:i', strtotime($student['created_at'])) ?><br>
        <strong>Update Terakhir:</strong> <?= date('d-m-Y H:i', strtotime($student['updated_at'])) ?><br>
    </div>
    <!-- Tambahkan info konseling, catatan, dsb jika perlu -->
<?php endif; ?>
