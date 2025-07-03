<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<!-- Daftar semua laporan untuk guru BK -->
<h3>Daftar Laporan Kejadian</h3>
<table border="1" cellpadding="5">
<tr><th>Tanggal</th><th>Murid</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr>
<?php foreach ($reports as $r): ?>
<tr>
    <td><?= $r['created_at'] ?></td>
    <td><?= esc($r['student_id']) ?></td>
    <td><?= esc($r['description']) ?></td>
    <td><?= esc($r['status']) ?></td>
    <td><a href="/incident-reports/review/<?= $r['id'] ?>">Review</a></td>
</tr>
<?php endforeach; ?>
</table>

<?= $this->endSection() ?>
