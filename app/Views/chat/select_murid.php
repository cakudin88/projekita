<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<!-- Pilih murid untuk chat (hanya guru BK) -->
<h3>Pilih Murid untuk Chat</h3>
<ul>
<?php foreach ($muridList as $murid): ?>
    <li><a href="/chat/<?= $murid['id'] ?>">Chat dengan <?= esc($murid['full_name']) ?></a></li>
<?php endforeach; ?>
</ul>

<?= $this->endSection() ?>
